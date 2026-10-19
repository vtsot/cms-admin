<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Course;

use App\Contract\Dictionary\Traits\EnumValuesTrait;

enum SubscriptionSupportPriority: string
{
    use EnumValuesTrait;

    case High    = 'high';
    case Highest = 'highest';
}
