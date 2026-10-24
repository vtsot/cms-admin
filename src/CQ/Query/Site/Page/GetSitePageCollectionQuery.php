<?php

declare(strict_types=1);

namespace App\CQ\Query\Site\Page;

use App\DTO\Collection\PageCriteriaDTO;
use Symfony\Component\Uid\Uuid;

/**
 * @see GetSitePageCollectionHandler
 */
final readonly class GetSitePageCollectionQuery
{
    public function __construct(
        public Uuid $siteId,
        public string $token,
        public PageCriteriaDTO $criteria,
    ) {
    }
}
