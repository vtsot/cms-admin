<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\RMI;

enum RequestQueryParam: string
{
    case Selection      = 'selection';
    case Delimiter      = '--';
    case ChildSelection = 'child-selection';
    case ChildDelimiter = '.';
}
