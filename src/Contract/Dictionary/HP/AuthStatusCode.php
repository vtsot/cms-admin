<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\HP;

enum AuthStatusCode: int
{
    case Unknown           = -1;
    case Ok                = 0;
    case UnknownCompany    = 1;
    case IncorrectPassword = 2;
    case UsernameNotFound  = 3;
    case InactiveLicence   = 4;
    case ExpiredVrid       = 5;
    case NoRights          = 6;
    case UserBanned        = 7;
}
