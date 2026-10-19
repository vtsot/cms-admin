<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Cms;

enum CourseThumbnailViewType: string
{
    case Regular       = 'regular';
    case SimpleRegular = 'simple-regular';
    case Simple        = 'simple';
}
