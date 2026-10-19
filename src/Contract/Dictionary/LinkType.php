<?php

declare(strict_types=1);

namespace App\Contract\Dictionary;

enum LinkType: string
{
    case Primary   = 'primary';
    case Secondary = 'secondary';
}
