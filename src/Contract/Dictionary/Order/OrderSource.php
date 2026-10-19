<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Order;

use App\Contract\Dictionary\Traits\EnumValuesTrait;

enum OrderSource: string
{
    use EnumValuesTrait;

    case Shopware = 'shopware';
    case Local    = 'local';
}
