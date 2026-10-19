<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\User;

enum UserType: string
{
    case User    = 'USER';
    case Trainer = 'TRAINER';
}
