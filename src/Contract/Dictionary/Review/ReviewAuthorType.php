<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Review;

use App\Contract\Dictionary\Traits\EnumValuesTrait;

enum ReviewAuthorType: string
{
    use EnumValuesTrait;

    case Patient   = 'patient';
    case Caregiver = 'caregiver';
}
