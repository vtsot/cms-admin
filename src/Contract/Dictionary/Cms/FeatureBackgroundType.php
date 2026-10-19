<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Cms;

use App\Contract\Dictionary\Traits\EnumValuesTrait;

enum FeatureBackgroundType: string
{
    use EnumValuesTrait;

    case Image = 'image';
    case Video = 'video';
}
