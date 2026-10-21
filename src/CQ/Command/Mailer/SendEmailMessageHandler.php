<?php

declare(strict_types=1);

namespace App\CQ\Command\Mailer;

use App\Contract\Dictionary\MailHeader;
use App\Contract\Dictionary\MailStatus;
use App\CQ\Command\MailLog\CreateMailLogCommand;
use App\Service\MessageBusHandler;
use JetBrains\PhpStorm\ArrayShape;
use Ramsey\Uuid\Uuid;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Messenger\SendEmailMessage;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Header\MailboxHeader;
use Symfony\Component\Mime\Header\MailboxListHeader;
use Symfony\Component\Mime\Message;
use Symfony\Component\Mime\Part\AbstractPart;
use Symfony\Component\Mime\Part\Multipart\AlternativePart;
use Symfony\Component\Mime\Part\Multipart\MixedPart;
use Symfony\Component\Mime\Part\TextPart;
use Symfony\Component\Mime\RawMessage;
use Throwable;
use Twig\Environment;

use function array_values;
use function trim;

readonly class SendEmailMessageHandler
{
    public function __construct(
        private TransportInterface $transport,
        private MessageBusHandler $messageBusHandler,
        private Environment $twig,
    ) {
    }

    public function __invoke(SendEmailMessage $message): ?SentMessage
    {
        try {
            $sentMessage = $this->transport->send($message->getMessage(), $message->getEnvelope());

            $status          = MailStatus::Sent;
            $debug           = $sentMessage ? $sentMessage->getDebug() : '';
            $originalMessage = $sentMessage->getOriginalMessage();
        } catch (Throwable $e) {
            $sentMessage = null;

            $status          = MailStatus::Error;
            $debug           = $e->getMessage();
            $originalMessage = $message->getMessage();
        }

        $this->createMailLog($originalMessage, $status, $debug);

        return $sentMessage;
    }

    private function createMailLog(RawMessage $originalMessage, MailStatus $status, ?string $debug): void
    {
        $id         = null;
        $to         = null;
        $from       = null;
        $replyTo    = null;
        $returnPath = null;
        $cc         = null;
        $bcc        = null;
        $subject    = null;
        $text       = null;
        $html       = null;
        $siteId     = null;

        // using this approach since when email sent all headers are compiled
        // in Email instance they might be not compiled
        if ($originalMessage instanceof Message && $status === MailStatus::Sent) {
            $headers = $originalMessage->getPreparedHeaders();

            $id = $headers->get('message-id')?->getBodyAsString();

            if ($id !== null) {
                $id = trim($id, '<>');
            }

            $to         = $headers->get('to')?->getBodyAsString();
            $from       = $headers->get('from')?->getBodyAsString();
            $replyTo    = $headers->get('reply-to')?->getBodyAsString();
            $returnPath = $headers->get('return-path')?->getBodyAsString();
            $cc         = $headers->get('cc')?->getBodyAsString();
            $bcc        = $headers->get('bcc')?->getBodyAsString();
            $subject    = $headers->get('subject')?->getBodyAsString();
            $siteId     = $headers->get(MailHeader::SITE_ID)?->getBodyAsString();

            [$text, $html] = array_values($this->extractHtmlAndText($originalMessage->getBody()));
        }

        if ($originalMessage instanceof Email && $status === MailStatus::Error) {
            $to         = $originalMessage->getTo() ? (new MailboxListHeader('to', $originalMessage->getTo()))->getBodyAsString() : null;
            $from       = $originalMessage->getFrom() ? (new MailboxListHeader('from', $originalMessage->getFrom()))->getBodyAsString() : null;
            $replyTo    = $originalMessage->getReplyTo() ? (new MailboxListHeader('reply-to', $originalMessage->getReplyTo()))->getBodyAsString() : null;
            $returnPath = $originalMessage->getReturnPath() ? (new MailboxHeader('return-path', $originalMessage->getReturnPath()))->getBodyAsString() : null;
            $cc         = $originalMessage->getCc() ? (new MailboxListHeader('cc', $originalMessage->getCc()))->getBodyAsString() : null;
            $bcc        = $originalMessage->getBcc() ? (new MailboxListHeader('bcc', $originalMessage->getBcc()))->getBodyAsString() : null;
            $subject    = $originalMessage->getSubject();
            $text       = $originalMessage->getTextBody();
            $html       = $originalMessage->getHtmlBody();
            $siteId     = $originalMessage->getPreparedHeaders()->get(MailHeader::SITE_ID)?->getBodyAsString();
        }

        if ($originalMessage instanceof TemplatedEmail) {
            if ($text === null && $originalMessage->getTextTemplate()) {
                $text = $this->twig->render($originalMessage->getTextTemplate(), $originalMessage->getContext());
            }

            if ($html === null && $originalMessage->getHtmlTemplate()) {
                $html = $this->twig->render($originalMessage->getHtmlTemplate(), $originalMessage->getContext());
            }
        }

        try {
            $this->messageBusHandler->handleCommand(
                new Envelope(
                    new CreateMailLogCommand(
                        $id,
                        $status,
                        $debug,
                        $from,
                        $replyTo,
                        $returnPath,
                        $to,
                        $cc,
                        $bcc,
                        $subject,
                        $text,
                        $html,
                        $siteId ? Uuid::fromString($siteId) : null,
                    ),
                    [new DispatchAfterCurrentBusStamp()]
                )
            );
        } catch (Throwable) {
        }
    }

    #[ArrayShape([
        'text' => 'string|null',
        'html' => 'string|null',
    ])]
    private function extractHtmlAndText(AbstractPart $part): array
    {
        $result = ['text' => null, 'html' => null];

        $body = null;

        if ($part instanceof AlternativePart) {
            $body = $part;
        } elseif ($part instanceof MixedPart) {
            foreach ($part->getParts() as $subPart) {
                if ($subPart instanceof AlternativePart) {
                    $body = $subPart;

                    break;
                }
            }
        }

        if ($body instanceof AlternativePart) {
            foreach ($body->getParts() as $subPart) {
                if ($subPart instanceof TextPart && $subPart->getMediaSubtype() === 'html') {
                    $result['html'] = $subPart->getBody();
                } elseif ($subPart instanceof TextPart && $subPart->getMediaSubtype() === 'plain') {
                    $result['text'] = $subPart->getBody();
                }
            }
        }

        return $result;
    }
}
