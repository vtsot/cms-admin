<?php

declare(strict_types=1);

namespace App\Contract\Dictionary;

use App\Contract\Dictionary\Traits\EnumValuesTrait;

enum CategoryCollectionType: string
{
    use EnumValuesTrait;

    case All             = 'all';
    case CoursePopular   = 'course-popular';
    case ManualSelection = 'manual-selection';

    public function isCoursePopular(): bool
    {
        return self::CoursePopular->value === $this->value;
    }

    public function isManualSelection(): bool
    {
        return self::ManualSelection->value === $this->value;
    }
}
