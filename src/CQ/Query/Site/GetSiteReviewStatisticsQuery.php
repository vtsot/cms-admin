<?php

declare(strict_types=1);

namespace App\CQ\Query\Site;


use Symfony\Component\Uid\Uuid;

/**
 * @see GetSiteReviewStatisticsHandler
 */
readonly class GetSiteReviewStatisticsQuery
{
    public function __construct(
        public string $siteToken,
        public Uuid $siteId,
        public ?string $query,
        public ?Uuid $reasonId,
    ) {
    }
}
