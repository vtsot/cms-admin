<?php

declare(strict_types=1);

namespace App\Contract\Dictionary;

enum RegistrationType: string
{
    case SSO   = 'sso';
    case Email = 'email';
}
