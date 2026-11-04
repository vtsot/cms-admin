<?php

declare(strict_types=1);

namespace App\Message\Query\Site;

use App\Contract\Dictionary\NavigationType;
use App\MessageHandler\Query\Site\GetNavigationTreeHandler;
use App\Security\User\ApiSiteUser;

/**
 * @see GetNavigationTreeHandler
 */
readonly class GetNavigationTreeQuery
{
    public function __construct(
        public ApiSiteUser $user,
        public NavigationType $type,
    ) {
    }
}
