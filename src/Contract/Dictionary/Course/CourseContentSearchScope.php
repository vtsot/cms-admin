<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Course;

use App\Contract\Dictionary\Traits\EnumValuesTrait;

enum CourseContentSearchScope: string
{
    use EnumValuesTrait;

    case All    = 'all';
    case Course = 'course';
    case Video  = 'video';
}
