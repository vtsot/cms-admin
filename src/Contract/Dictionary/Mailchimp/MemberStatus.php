<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Mailchimp;

enum MemberStatus: string
{
    case Subscribed    = 'subscribed';
    case Unsubscribed  = 'unsubscribed';
    case Cleaned       = 'cleaned';
    case Pending       = 'pending';
    case Transactional = 'transactional';
}
