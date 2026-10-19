<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\RMI;

enum Provider: string
{
    case HellaGutmann = 'hg';
    case HaynesPro    = 'hp';
    case Varta        = 'varta';
}
