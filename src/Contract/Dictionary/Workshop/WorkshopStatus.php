<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Workshop;

enum WorkshopStatus: string
{
    case Pending  = 'pending';
    case Active   = 'active';
    case Inactive = 'inactive';
}
