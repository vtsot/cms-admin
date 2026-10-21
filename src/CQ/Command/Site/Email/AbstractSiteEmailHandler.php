<?php

declare(strict_types=1);

namespace App\CQ\Command\Site\Email;

use App\Contract\Dictionary\MailHeader;
use App\Entity\EmailTemplate;
use App\Entity\Site\SiteSettings;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Header\Headers;

use function array_keys;
use function array_values;
use function explode;
use function mb_substr;
use function str_replace;
use function trim;

abstract class AbstractSiteEmailHandler
{
    protected function createTemplatedEmail(
        string $path,
        SiteSettings $settings,
        EmailTemplate $template,
    ): TemplatedEmail {
        $headers        = (new Headers())->addTextHeader(MailHeader::SITE_ID, $settings->getSite()?->getId()?->toString());
        $templatedEmail = new TemplatedEmail($headers);
        $templatedEmail
            ->htmlTemplate($path)
            ->sender(new Address($settings->getSenderEmail(), $settings->getSenderName() ?? ''));

        if ($settings->getFromEmail()) {
            $templatedEmail->from(new Address($settings->getFromEmail(), $settings->getFromName() ?? ''));
        }

        if ($template->getReplyTo()) {
            $templatedEmail->replyTo(new Address($template->getReplyTo()));
        }

        return $templatedEmail;
    }

    protected function handlePlaceholders(?string $source, array $placeholders): string
    {
        return $source
            ? str_replace(array_keys($placeholders), array_values($placeholders), $source)
            : '';
    }

    /**
     * @param array<string, string> $additionAddresses
     *
     * @return array<int, Address>
     */
    protected function resolveEmailAddresses(EmailTemplate $template, array $additionAddresses = []): array
    {
        $addresses = [];

        foreach ($additionAddresses as $address => $name) {
            $email = trim((string) $address);

            if ($email) {
                $addresses[$email] = new Address($email, trim((string) $name));
            }
        }

        if ($template->isSendToManagersActive()
            && $site = $template->getSite()
        ) {
            foreach ($site->getUsers() as $user) {
                $email = trim((string) $user->getEmail());

                if ($email) {
                    $addresses[$email] = new Address($email, trim($user->getFullName()));
                }
            }
        }

        if ($template->getSendTo()) {
            foreach (explode(',', $template->getSendTo()) as $email) {
                $email = trim($email);

                if ($email) {
                    $addresses[$email] = new Address(trim($email));
                }
            }
        }

        return array_values($addresses);
    }

    /**
     * @return array<int, string>
     */
    protected function resolveEmailData(EmailTemplate $template, array $placeholders): array
    {
        $subject = mb_substr($this->handlePlaceholders($template->getSubject(), $placeholders), 0, 255);
        $html    = $this->handlePlaceholders($template->getHtml(), $placeholders);
        $text    = $this->handlePlaceholders($template->getText(), $placeholders);

        return [$subject, $html, $text];
    }
}
