<?php

declare(strict_types=1);

namespace App\CQ\Query\Site;

/**
 * @see GetSiteFaviconHandler
 */
readonly class GetSiteFaviconQuery
{
    public function __construct(
        public string $image,
    ) {
    }
}
