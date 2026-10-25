<?php

declare(strict_types=1);

namespace App\Message\Query\Site;

use App\MessageHandler\Query\Site\GetSiteFaviconHandler;

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
