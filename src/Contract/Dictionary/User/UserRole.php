<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\User;

use App\Contract\Dictionary\Traits\EnumValuesTrait;

enum UserRole: string
{
    use EnumValuesTrait;

    case Supervisor  = 'ROLE_SUPERVISOR';
    case Admin       = 'ROLE_ADMIN';
    case User        = 'ROLE_USER';
    case SiteManager = 'ROLE_SITE_MANAGER';
}
