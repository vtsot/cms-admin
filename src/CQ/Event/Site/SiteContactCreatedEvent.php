<?php

declare(strict_types=1);

namespace App\CQ\Event\Site;

use Symfony\Component\Uid\Uuid;

/** @see SiteContactCreatedHandler */
readonly class SiteContactCreatedEvent
{
    public function __construct(
        public Uuid $contactId,
        public Uuid $siteId,
        public string $siteToken,
    ) {
    }
}
