<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Workshop;

use App\Contract\Dictionary\Traits\EnumValuesTrait;

enum WorkshopUserRole: string
{
    use EnumValuesTrait;

    case Admin    = 'ROLE_WORKSHOP_ADMIN';
    case Employee = 'ROLE_WORKSHOP_EMPLOYEE';
}
