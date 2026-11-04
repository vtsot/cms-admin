<?php

declare(strict_types=1);

namespace App\Message\Query\Site;

use App\MessageHandler\Query\Site\GetBannerRandomHandler;
use App\Security\User\ApiSiteUser;

/**
 * @see GetBannerRandomHandler
 */
class GetBannerRandomQuery
{
    public function __construct(
        public ApiSiteUser $user,
    ) {
    }
}
