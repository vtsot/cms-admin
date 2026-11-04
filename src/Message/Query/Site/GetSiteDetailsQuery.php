<?php

declare(strict_types=1);

namespace App\Message\Query\Site;

use App\MessageHandler\Query\Site\GetSiteDetailsHandler;
use App\Security\User\ApiSiteUser;

/**
 * @see GetSiteDetailsHandler
 */
readonly class GetSiteDetailsQuery
{
    public function __construct(
        public ApiSiteUser $user,
    ) {
    }
}
