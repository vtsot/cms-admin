<?php

declare(strict_types=1);

namespace App\Contract\Dictionary;

use App\Contract\Dictionary\Traits\EnumValuesTrait;

enum ContentPermissionType: string
{
    use EnumValuesTrait;

    case All = 'all';

    case NotLoggedIn      = 'not-logged-in';
    case Registered       = 'registered';
    case WithSubscription = 'with-subscription';
}
