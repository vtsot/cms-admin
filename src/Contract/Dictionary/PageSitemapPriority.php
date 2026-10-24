<?php

declare(strict_types=1);

namespace App\Contract\Dictionary;

use App\Contract\Dictionary\Traits\EnumValuesTrait;

enum PageSitemapPriority: string
{
    use EnumValuesTrait;

    public const float DEFAULT = 0.5;
    case Priority01            = '0.1';
    case Priority02            = '0.2';
    case Priority03            = '0.3';
    case Priority04            = '0.4';
    case Priority05            = '0.5';
    case Priority06            = '0.6';
    case Priority07            = '0.7';
    case Priority08            = '0.8';
    case Priority09            = '0.9';
    case Priority10            = '1.0';
}
