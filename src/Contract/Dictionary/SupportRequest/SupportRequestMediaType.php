<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\SupportRequest;

use App\Contract\Dictionary\Traits\EnumValuesTrait;

enum SupportRequestMediaType: string
{
    use EnumValuesTrait;

    case Image = 'image';
    case Video = 'video';
}
