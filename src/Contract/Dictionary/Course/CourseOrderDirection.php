<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Course;

use App\Contract\Dictionary\Traits\EnumValuesTrait;

enum CourseOrderDirection: string
{
    use EnumValuesTrait;

    case Asc  = 'asc';
    case Desc = 'desc';
}
