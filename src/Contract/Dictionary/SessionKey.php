<?php

declare(strict_types=1);

namespace App\Contract\Dictionary;

enum SessionKey: string
{
    case IsNewUser = 'is_new_user';
}
