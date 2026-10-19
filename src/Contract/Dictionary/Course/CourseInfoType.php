<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Course;

use App\Contract\Dictionary\Traits\EnumValuesTrait;

enum CourseInfoType: string
{
    use EnumValuesTrait;

    case Course  = 'course';
    case Chapter = 'chapter';
}
