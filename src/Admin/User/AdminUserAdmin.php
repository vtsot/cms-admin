<?php

declare(strict_types=1);

namespace App\Admin\User;

use App\Contract\Dictionary\User\UserRole;

class AdminUserAdmin extends AbstractUserAdmin
{
    public const bool MULTIPLE_ROLES           = true;
    public const bool USE_GOOGLE_AUTHENTICATOR = true;

    protected function resolveUserRoles(): array
    {
        return [
            UserRole::Admin->value,
        ];
    }
}
