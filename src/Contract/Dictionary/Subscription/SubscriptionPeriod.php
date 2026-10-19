<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Subscription;

use App\Contract\Dictionary\Traits\EnumValuesTrait;

enum SubscriptionPeriod: int
{
    use EnumValuesTrait;

    case Month = 1;
    case Year  = 12;
}
