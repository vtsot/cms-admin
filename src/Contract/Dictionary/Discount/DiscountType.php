<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Discount;

enum DiscountType: string
{
    case Absolute   = 'absolute';
    case Percentage = 'percentage';
}
