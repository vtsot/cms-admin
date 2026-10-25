<?php

declare(strict_types=1);

namespace App\Message\Query\Site;

use App\DTO\Collection\PageCriteriaDTO;
use App\MessageHandler\Query\Site\GetSitePageCollectionHandler;
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
