<?php

declare(strict_types=1);

namespace App\Contract\Dictionary;

enum NavigationType: string
{
    case Top    = 'top';
    case Bottom = 'bottom';
}
