<?php

declare(strict_types=1);

namespace App\CQ\Query\Site;

use Symfony\Component\Uid\Uuid;

/**
 * @see GetSiteDetailsHandler
 */
readonly class GetSiteDetailsQuery
{
    public function __construct(
        public Uuid $siteId,
        public string $token,
    ) {
    }
}
