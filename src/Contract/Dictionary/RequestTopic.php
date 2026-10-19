<?php

declare(strict_types=1);

namespace App\Contract\Dictionary;

use App\Contract\Dictionary\Traits\EnumValuesTrait;

enum RequestTopic: string
{
    use EnumValuesTrait;
    case LoginRegistration      = 'LOGIN_REGISTRATION';
    case MembershipSubscription = 'MEMBERSHIP_SUBSCRIPTION';
    case ExperienceComment      = 'EXPERIENCE_COMMENT';
    case TechnicalProblem       = 'TECHNICAL_PROBLEM';
    case Feedback               = 'FEEDBACK';
    case AccountSettings        = 'ACCOUNT_SETTINGS';
    case Miscellaneous          = 'MISCELLANEOUS';
}
