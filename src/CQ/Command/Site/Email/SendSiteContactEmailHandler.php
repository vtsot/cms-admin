<?php

declare(strict_types=1);

namespace App\CQ\Command\Site\Email;

use App\Contract\MessageHandler\CommandHandlerInterface;
use App\Entity\EmailTemplate;
use App\Exception\Validation\EntityNotFoundException;
use App\Repository\ContactRepository;
use App\Repository\EmailTemplateRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Contracts\Translation\TranslatorInterface;

use function strip_tags;

class SendSiteContactEmailHandler extends AbstractSiteEmailHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly TranslatorInterface $translator,
        private readonly ContactRepository $contactRepository,
        private readonly EmailTemplateRepository $emailTemplateRepository,
    ) {
    }

    public function __invoke(SendSiteContactEmailCommand $command): void
    {
        $contact = $this->contactRepository->findOneByIdAndActiveSiteIdAndSiteToken($command->contactId, $command->siteId, $command->siteToken);

        if ($contact === null) {
            throw new EntityNotFoundException($this->translator->trans('CONTACT.NOT_FOUND'));
        }

        $site     = $contact->getSite();
        $settings = $site?->getSettings();
        $template = $site ? $this->emailTemplateRepository->findOneActiveBySiteIdAndCode($site->getId(), EmailTemplate::CODE_CONTACT) : null;

        // check requirements
        if ($site === null
            || $settings === null
            || $template === null
            || $settings->getSenderEmail() === null
        ) {
            return;
        }

        $addresses = $this->resolveEmailAddresses($template);

        if (!$addresses) {
            return;
        }

        $placeholders = [
            '[[NAME]]'    => $contact->getName(),
            '[[EMAIL]]'   => $contact->getEmail(),
            '[[MESSAGE]]' => strip_tags($contact->getMessage() ?? ''),
        ];

        // email data
        [$subject, $html, $text] = $this->resolveEmailData($template, $placeholders);

        foreach ($addresses as $address) {
            $templatedEmail = $this
                ->createTemplatedEmail('email/contact.html.twig', $settings, $template)
                ->to($address)
                ->subject($subject)
                ->context(['subject' => $subject, 'content' => $html]);

            if (!$templatedEmail->getReplyTo()) {
                $templatedEmail->replyTo(new Address($contact->getEmail(), $contact->getName()));
            }

            if ($text) {
                $templatedEmail->text($text);
            }

            $this->mailer->send($templatedEmail);
        }
    }
}
