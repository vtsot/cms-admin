<?php

declare(strict_types=1);

namespace App\Message\Command\Site;

use App\MessageHandler\Command\Site\UpdateSiteHomepageHandler;
use Symfony\Component\Uid\Uuid;

/**
 * @see UpdateSiteHomepageHandler
 */
readonly class UpdateSiteHomepageCommand
{
    public function __construct(
        public Uuid $siteId,
        public Uuid $pageId,
    ) {
    }
}
