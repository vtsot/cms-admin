<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Cms;

enum CourseCollectionBlockViewType: string
{
    case Slider = 'slider';
    case Block  = 'block';
}
