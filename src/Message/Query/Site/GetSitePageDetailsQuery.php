<?php

declare(strict_types=1);

namespace App\Message\Query\Site;

use App\MessageHandler\Query\Site\GetSitePageDetailsHandler;
use App\Security\User\ApiSiteUser;

/**
 * @see GetSitePageDetailsHandler
 */
readonly class GetSitePageDetailsQuery
{
    public function __construct(
        public ApiSiteUser $user,
        public string $slug,
    ) {
    }
}
