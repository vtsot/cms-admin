<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\User;

use App\Contract\Dictionary\Traits\EnumValuesTrait;

enum UserRole: string
{
    use EnumValuesTrait;

    case User        = 'ROLE_USER';
    case PageEditor  = 'ROLE_PAGE_EDITOR';
    case VideoEditor = 'ROLE_VIDEO_EDITOR';
    case Admin       = 'ROLE_ADMIN';
    case Supervisor  = 'ROLE_SUPERVISOR';
    case Trainer     = 'ROLE_TRAINER';
}
