<?php

declare(strict_types=1);

namespace App\ApiRequest\SiteReview;

use App\ApiRequest\AbstractGetCollectionRequest;
use App\Contract\Dictionary\Review\ReviewSortType;

class GetSiteReviewCollectionRequest extends AbstractGetCollectionRequest
{
    public const DEFAULT_ORDER_DIRECTION = null;

    public readonly ?string $reasonId;
    public readonly ?string $sort;

    public function __construct(
        ?string $query,
        ?string $reasonId,
        ?string $sort,
        ?int $page = null,
        ?int $perPage = null,
    ) {
        $this->reasonId = $reasonId ?? null;
        $this->sort     = ReviewSortType::tryFrom((string) $sort)
            ? ReviewSortType::from((string) $sort)->value
            : ReviewSortType::MostRecent->value;

        // the current collection uses its own sorting
        // init parent without sort (parent::$sort = null)
        parent::__construct($query, null, $page, $perPage);
    }
}
