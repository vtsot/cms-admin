<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Cms;

enum FeatureType: string
{
    case Advanced = 'advanced';
    case Simple   = 'simple';
}
