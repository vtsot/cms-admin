<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Course;

use App\Contract\Dictionary\Traits\EnumValuesTrait;

enum CourseFilterDurationPeriods: string
{
    use EnumValuesTrait;

    case Period_1 = '0-1';
    case Period_2 = '1-3';
    case Period_3 = '3-6';
    case Period_4 = '6-12';
    case Period_5 = '12+';
}
