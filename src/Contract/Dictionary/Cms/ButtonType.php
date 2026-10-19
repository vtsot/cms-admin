<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Cms;

use App\Contract\Dictionary\Traits\EnumValuesTrait;

enum ButtonType: string
{
    use EnumValuesTrait;

    case Primary   = 'primary';
    case Secondary = 'secondary';
    case Link      = 'link';
}
