<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Site;

use App\Contract\Dictionary\Traits\EnumValuesTrait;

enum SiteSettingsImagePosition: string
{
    use EnumValuesTrait;

    case Center = 'center';
    case Left   = 'left';
    case Right  = 'right';
}
