<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Course;

use App\Contract\Dictionary\Traits\EnumValuesTrait;

enum CourseType: string
{
    use EnumValuesTrait;

    case Repair        = 'repair';
    case Trainings     = 'trainings';
    case Entertainment = 'entertainment';
}
