<?php

declare(strict_types=1);

namespace App\CQ\Query\Page;

use Symfony\Component\Uid\Uuid;

/**
 * @see GetSitemapPageBySiteTokenAndSiteIdCollectionHandler
 */
readonly class GetSitemapPageBySiteTokenAndSiteIdCollectionQuery
{
    public function __construct(
        public string $siteToken,
        public Uuid $siteId,
    ) {
    }
}
