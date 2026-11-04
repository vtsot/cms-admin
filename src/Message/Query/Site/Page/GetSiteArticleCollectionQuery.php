<?php

declare(strict_types=1);

namespace App\Message\Query\Site\Page;

use App\DTO\Collection\PageCriteriaDTO;
use App\MessageHandler\Query\Site\Page\GetSiteArticleCollectionHandler;
use App\Security\User\ApiSiteUser;

/**
 * @see GetSiteArticleCollectionHandler
 */
final readonly class GetSiteArticleCollectionQuery
{
    public function __construct(
        public ApiSiteUser $user,
        public PageCriteriaDTO $criteria,
    ) {
    }
}
