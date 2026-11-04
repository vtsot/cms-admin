<?php

declare(strict_types=1);

namespace App\Message\Query\Site;

use App\DTO\Collection\PageCriteriaDTO;
use App\MessageHandler\Query\Site\GetSitePageCollectionHandler;
use App\Security\User\ApiSiteUser;

/**
 * @see GetSitePageCollectionHandler
 */
final readonly class GetSitePageCollectionQuery
{
    public function __construct(
        public ApiSiteUser $user,
        public PageCriteriaDTO $criteria,
    ) {
    }
}
