<?php

declare(strict_types=1);

namespace App\Message\Command\Site;

use App\MessageHandler\Command\Site\SiteResetTokenHandler;
use Symfony\Component\Uid\Uuid;

/**
 * @see SiteResetTokenHandler
 */
readonly class SiteResetTokenCommand
{
    public function __construct(
        public Uuid $siteId,
    ) {
    }
}
