<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Review;

use App\Contract\Dictionary\Traits\EnumValuesTrait;

enum ReviewAuthorGender: string
{
    use EnumValuesTrait;

    case Male   = 'male';
    case Female = 'female';
}
