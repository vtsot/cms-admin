<?php

declare(strict_types=1);

namespace App\CQ\Command\Site;

use Symfony\Component\Uid\Uuid;

/**
 * @see CreateDefaultSiteEmailTemplatesHandler
 */
readonly class CreateDefaultSiteEmailTemplatesCommand
{
    public function __construct(
        public Uuid $siteId,
    ) {
    }
}
