<?php

declare(strict_types=1);

namespace App\Message\Command\MailLog;

use App\Contract\Dictionary\MailStatus;
use App\MessageHandler\Command\MailLog\CreateMailLogHandler;
use Symfony\Component\Uid\Uuid;

/**
 * @see CreateMailLogHandler
 */
readonly class CreateMailLogCommand
{
    public function __construct(
        public ?string $id,
        public MailStatus $status,
        public ?string $debug = null,
        public ?string $from = null,
        public ?string $replyTo = null,
        public ?string $returnPath = null,
        public ?string $to = null,
        public ?string $cc = null,
        public ?string $bcc = null,
        public ?string $subject = null,
        public ?string $text = null,
        public ?string $html = null,
        public ?Uuid $siteId = null,
    ) {
    }
}
