<?php

declare(strict_types=1);

namespace App\Contract\Dictionary;

enum ShareThingType: string
{
    case EarlyAccess = 'early-access';
    case Course      = 'course';
    case Page        = 'page';
}
