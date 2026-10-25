<?php

declare(strict_types=1);

namespace App\Message\Command\Site;

use App\MessageHandler\Command\Site\CreateDefaultSiteHomepageHandler;
use Symfony\Component\Uid\Uuid;

/**
 * @see CreateDefaultSiteHomepageHandler
 */
readonly class CreateDefaultSiteHomepageCommand
{
    public function __construct(
        public Uuid $siteId,
    ) {
    }
}
