<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Workshop;

enum WorkshopUserStatus: string
{
    case Pending  = 'pending';
    case Active   = 'active';
    case Inactive = 'inactive';

    public static function values(): array
    {
        return [self::Active->value, self::Inactive->value];
    }
}
