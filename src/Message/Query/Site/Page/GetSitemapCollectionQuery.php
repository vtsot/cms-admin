<?php

declare(strict_types=1);

namespace App\Message\Query\Site\Page;

use App\MessageHandler\Query\Site\Page\GetSitemapCollectionHandler;
use App\Security\User\ApiSiteUser;

/**
 * @see GetSitemapCollectionHandler
 */
readonly class GetSitemapCollectionQuery
{
    public function __construct(
        public ApiSiteUser $user,
    ) {
    }
}
