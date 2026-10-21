<?php

declare(strict_types=1);

namespace App\ApiRequest\SiteReview;

use App\Contract\ApiRequest\ApiRequestInterface;

readonly class GetSiteReviewStatisticsRequest implements ApiRequestInterface
{
    public function __construct(
        public ?string $query = null,
        public ?string $reasonId = null,
    ) {
    }
}
