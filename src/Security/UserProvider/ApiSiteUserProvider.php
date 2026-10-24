<?php

declare(strict_types=1);

namespace App\Security\UserProvider;

use App\Contract\Dictionary\User\UserRole;
use App\Security\User\ApiSiteUser;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class ApiSiteUserProvider implements UserProviderInterface
{
    public function supportsClass(string $class): bool
    {
        return $class === ApiSiteUser::class;
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        return new ApiSiteUser($identifier, [UserRole::ApiSite]);
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        return $user;
    }
}
