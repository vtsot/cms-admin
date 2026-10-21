<?php

declare(strict_types=1);

namespace App\CQ\Query\Site;

use App\Contract\Dictionary\Review\ReviewSortType;
use App\CQ\Query\AbstractGetCollectionQuery;
use Symfony\Component\Uid\Uuid;

/**
 * @see GetSiteReviewCollectionHandler
 */
readonly class GetSiteReviewCollectionQuery extends AbstractGetCollectionQuery
{
    public function __construct(
        public string $siteToken,
        public Uuid $siteId,
        ?string $query,
        ?int $page,
        ?int $perPage,
        public ?Uuid $reasonId,
        public ReviewSortType $sortType,
    ) {
        parent::__construct($query, $page, $perPage);
    }
}
