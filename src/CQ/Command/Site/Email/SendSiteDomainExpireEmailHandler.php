<?php

declare(strict_types=1);

namespace App\CQ\Command\Site\Email;

use App\Contract\MessageHandler\CommandHandlerInterface;
use App\Repository\EmailTemplateRepository;
use Symfony\Component\Mailer\MailerInterface;

class SendSiteDomainExpireEmailHandler extends AbstractSiteEmailHandler implements CommandHandlerInterface
{
    private const DATE_FORMAT = 'F j, Y';

    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly EmailTemplateRepository $emailTemplateRepository,
    ) {
    }

    public function __invoke(SendSiteDomainExpireEmailCommand $command): void
    {
        $template = $this->emailTemplateRepository->findOneActiveBySiteIdAndCode($command->siteId, $command->template);
        $site     = $template?->getSite();
        $settings = $site?->getSettings();

        // check requirements
        if ($site === null
            || $settings === null
            || $template === null
            || $settings->getSenderEmail() === null
        ) {
            return;
        }

        $additionAddresses = $site->getRegistrarEmail() ? [$site->getRegistrarEmail() => $site->getRegistrarName()] : [];
        $addresses         = $this->resolveEmailAddresses($template, $additionAddresses);

        if (!$addresses) {
            return;
        }

        $placeholders = [
            '[[REGISTRAR_NAME]]'  => $site->getRegistrarName() ?? '',
            '[[REGISTRAR_EMAIL]]' => $site->getRegistrarEmail() ?? '',
            '[[DOMAIN]]'          => $site->getDomain() ?? '',
            '[[EXPIRE_AT]]'       => $site->getExpireAt() ? $site->getExpireAt()->format(self::DATE_FORMAT) : '',
        ];

        // email data
        [$subject, $html, $text] = $this->resolveEmailData($template, $placeholders);

        foreach ($addresses as $address) {
            $templatedEmail = $this
                ->createTemplatedEmail('email/site-expire.html.twig', $settings, $template)
                ->to($address)
                ->subject($subject)
                ->context(['subject' => $subject, 'content' => $html]);

            if ($text) {
                $templatedEmail->text($text);
            }

            $this->mailer->send($templatedEmail);
        }
    }
}
