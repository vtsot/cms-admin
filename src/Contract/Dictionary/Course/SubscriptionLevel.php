<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Course;

enum SubscriptionLevel: string
{
    case Free    = 'free';
    case Premium = 'premium';
}
