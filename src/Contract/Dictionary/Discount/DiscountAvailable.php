<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Discount;

use App\Contract\Dictionary\Traits\EnumValuesTrait;

enum DiscountAvailable: string
{
    use EnumValuesTrait;

    case Subscription  = 'subscription';
    case SupportCredit = 'support-credit';
}
