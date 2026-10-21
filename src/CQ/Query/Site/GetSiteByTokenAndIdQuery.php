<?php

declare(strict_types=1);

namespace App\CQ\Query\Site;

use Symfony\Component\Uid\Uuid;

/**
 * @see GetSiteByTokenAndIdHandler
 */
readonly class GetSiteByTokenAndIdQuery
{
    public function __construct(
        public string $siteToken,
        public Uuid $siteId,
    ) {
    }
}
