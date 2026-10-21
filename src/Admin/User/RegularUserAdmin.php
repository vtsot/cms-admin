<?php

declare(strict_types=1);

namespace App\Admin\User;

use App\Contract\Dictionary\User\UserRole;

class RegularUserAdmin extends AbstractUserAdmin
{
    protected function resolveUserRoles(): array
    {
        return [
            UserRole::User->value,
        ];
    }
}
