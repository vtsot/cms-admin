<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Cms;

use App\Contract\Dictionary\Traits\EnumValuesTrait;

enum CmsBlockBackgroundType: string
{
    use EnumValuesTrait;

    case None          = 'none';
    case Image         = 'image';
    case Video         = 'video';
    case AdvancedVideo = 'advanced-video';
}
