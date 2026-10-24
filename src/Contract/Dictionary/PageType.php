<?php

declare(strict_types=1);

namespace App\Contract\Dictionary;

use App\Contract\Dictionary\Traits\EnumValuesTrait;

enum PageType: string
{
    use EnumValuesTrait;

    case Page    = 'page';
    case Article = 'article';
}
