<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Notification;

enum NotificationFrequency: string
{
    case Immediately = 'immediately';
    case Hourly      = 'hourly';
    case Daily       = 'daily';
    case Weekly      = 'weekly';
    case Monthly     = 'monthly';
}
