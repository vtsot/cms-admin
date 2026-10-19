<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\User;

enum UserSsoType: string
{
    case Facebook = 'facebook';
    case Google   = 'google';
    case LinkedIn = 'linkedin';
}
