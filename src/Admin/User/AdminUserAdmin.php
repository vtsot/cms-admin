<?php

declare(strict_types=1);

namespace App\Admin\User;

use App\Contract\Dictionary\User\UserRole;

class AdminUserAdmin extends AbstractUserAdmin
{
    public const USE_GOOGLE_AUTHENTICATOR = true;

    protected function resolveUserRoles(): array
    {
        return [
            UserRole::SiteManager->value,
            UserRole::Supervisor->value,
        ];
    }
}
