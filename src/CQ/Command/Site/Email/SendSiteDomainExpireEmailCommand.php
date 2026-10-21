<?php

declare(strict_types=1);

namespace App\CQ\Command\Site\Email;

use Symfony\Component\Uid\Uuid;

/**
 * @see SendSiteDomainExpireEmailHandler
 */
readonly class SendSiteDomainExpireEmailCommand
{
    public function __construct(
        public Uuid $siteId,
        public string $template,
    ) {
    }
}
