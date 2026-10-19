<?php

declare(strict_types=1);

namespace App\Contract\Dictionary;

enum MailStatus: string
{
    case Pending = 'pending';
    case Sent    = 'sent';
    case Error   = 'error';
}
