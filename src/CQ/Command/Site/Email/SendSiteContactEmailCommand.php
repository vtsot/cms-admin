<?php

declare(strict_types=1);

namespace App\CQ\Command\Site\Email;

use Symfony\Component\Uid\Uuid;

/**
 * @see SendSiteContactEmailHandler
 */
readonly class SendSiteContactEmailCommand
{
    public function __construct(
        public Uuid $contactId,
        public Uuid $siteId,
        public string $siteToken,
    ) {
    }
}
