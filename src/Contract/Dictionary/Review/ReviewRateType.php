<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Review;

use App\Contract\Dictionary\Traits\EnumValuesTrait;

enum ReviewRateType: string
{
    use EnumValuesTrait;

    case Like    = 'like';
    case Dislike = 'dislike';
    case Report  = 'report';
}
