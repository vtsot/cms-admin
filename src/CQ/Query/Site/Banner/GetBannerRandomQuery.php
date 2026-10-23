<?php

declare(strict_types=1);

namespace App\CQ\Query\Site\Banner;

use Symfony\Component\Uid\Uuid;

/**
 * @see GetBannerRandomHandler
 */
class GetBannerRandomQuery
{
    public function __construct(
        public Uuid $siteId,
        public string $token,
    ) {
    }
}
