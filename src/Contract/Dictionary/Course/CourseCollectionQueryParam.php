<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Course;

use App\Contract\Dictionary\Traits\EnumValuesTrait;

/**
 * @see CourseCollectionQueryParam.ts
 */
enum CourseCollectionQueryParam: string
{
    use EnumValuesTrait;

    case Query = 'q';

    case Makes          = 'mk';
    case Categories     = 'ct';
    case Certifications = 'cr';
    case Skills         = 'sk';
    case Languages      = 'ln';
    case Durations      = 'dr';
    case Tags           = 'tg';
    case Rating         = 'rt';
    case Trainers       = 'tr';

    case OrderBy        = 'ob';
    case OrderDirection = 'od';
}
