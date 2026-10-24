<?php

declare(strict_types=1);

namespace App\CQ\Query\Site\Page;

use Symfony\Component\Uid\Uuid;

/**
 * @see GetSitePageDetailsHandler
 */
readonly class GetSitePageDetailsQuery
{
    public function __construct(
        public Uuid $siteId,
        public string $token,
        public string $slug,
    ) {
    }
}
