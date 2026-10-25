<?php

declare(strict_types=1);

namespace App\Message\Command\Site;

use App\MessageHandler\Command\Site\ResetSiteTokenHandler;
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
