<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Notification;

enum NotificationChannel: string
{
    case Web   = 'web';
    case Email = 'email';
    case App   = 'push';
}
