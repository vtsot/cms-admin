<?php

declare(strict_types=1);

namespace App\CQ\Query\Page;

use Symfony\Component\Uid\Uuid;

/**
 * @see GetPageBySiteTokenAndSiteIdAndSlugHandler
 */
readonly class GetPageBySiteTokenAndSiteIdAndSlugQuery
{
    public function __construct(
        public string $siteToken,
        public Uuid $siteId,
        public string $slug,
    ) {
    }
}
