<?php

declare(strict_types=1);

namespace App\Message\Command\Site;

use App\MessageHandler\Command\Site\CreateContactHandler;
use App\Security\User\ApiSiteUser;

/**
 * @see CreateContactHandler
 */
class CreateContactCommand
{
    public function __construct(
        public ApiSiteUser $user,
        public ?string $name,
        public ?string $email,
        public ?string $message,
    ) {
    }
}
