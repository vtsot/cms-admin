<?php

declare(strict_types=1);

namespace App\Contract\Dictionary;

use App\Contract\Dictionary\Traits\EnumValuesTrait;

enum Experience: string
{
    use EnumValuesTrait;

    case Beginner = 'beginner';
    case Medium   = 'medium';
    case Expert   = 'expert';
}
