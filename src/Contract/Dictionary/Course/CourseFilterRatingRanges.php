<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Course;

use App\Contract\Dictionary\Traits\EnumValuesTrait;

enum CourseFilterRatingRanges: string
{
    use EnumValuesTrait;

    case Range1 = '1-1.5';
    case Range2 = '1.5-2.5';
    case Range3 = '2.5-3.5';
    case Range4 = '3.5-4.5';
    case Range5 = '4.5-5';
}
