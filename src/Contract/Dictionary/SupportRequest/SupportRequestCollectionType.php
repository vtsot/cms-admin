<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\SupportRequest;

use App\Contract\Dictionary\Traits\EnumValuesTrait;

enum SupportRequestCollectionType: string
{
    use EnumValuesTrait;

    case Open = 'open';
    case Done = 'done';
}
