<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Order;

use App\Contract\Dictionary\Traits\EnumValuesTrait;

enum OrderStatus: string
{
    use EnumValuesTrait;

    case Pending  = 'pending';
    case Canceled = 'canceled';
    case Paid     = 'paid';

    public function isStatusPaid(): bool
    {
        return self::Paid->value === $this->value;
    }
}
