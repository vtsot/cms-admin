<?php

declare(strict_types=1);

namespace App\Message\Query\Site\Page;

use App\MessageHandler\Query\Site\Page\GetSiteArticleDetailsHandler;
use App\Security\User\ApiSiteUser;

/**
 * @see GetSiteArticleDetailsHandler
 */
readonly class GetSiteArticleDetailsQuery
{
    public function __construct(
        public ApiSiteUser $user,
        public string $slug,
    ) {
    }
}
