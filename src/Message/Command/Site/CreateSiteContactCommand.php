<?php

declare(strict_types=1);

namespace App\Message\Command\Site;

use App\MessageHandler\Command\Site\CreateSiteContactHandler;
use App\Security\User\ApiSiteUser;

/**
 * @see CreateSiteContactHandler
 */
class CreateSiteContactCommand
{
    public function __construct(
        public ApiSiteUser $user,
        public array $fields,
        public array $context,
    ) {
    }
}
