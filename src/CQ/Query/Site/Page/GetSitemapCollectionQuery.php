<?php

declare(strict_types=1);

namespace App\CQ\Query\Site\Page;

use Symfony\Component\Uid\Uuid;

/**
 * @see GetSitemapCollectionHandler
 */
readonly class GetSitemapCollectionQuery
{
    public function __construct(
        public Uuid $siteId,
        public string $token,
    ) {
    }
}
