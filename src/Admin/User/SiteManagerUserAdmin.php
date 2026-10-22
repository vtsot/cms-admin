<?php

declare(strict_types=1);

namespace App\Admin\User;

use App\Contract\Dictionary\User\UserRole;

class SiteManagerUserAdmin extends AbstractUserAdmin
{
    public const bool MULTIPLE_ROLES           = false;
    public const bool USE_GOOGLE_AUTHENTICATOR = false;

    protected function resolveUserRoles(): array
    {
        return [
            UserRole::SiteManager->value,
        ];
    }
}
