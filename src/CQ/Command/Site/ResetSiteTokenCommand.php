<?php

declare(strict_types=1);

namespace App\CQ\Command\Site;


use Symfony\Component\Uid\Uuid;

/**
 * @see ResetSiteTokenHandler
 */
readonly class ResetSiteTokenCommand
{
    public function __construct(
        public Uuid $siteId,
    ) {
    }
}
