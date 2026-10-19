<?php

declare(strict_types=1);

namespace App\Contract\Notification;

use App\Notification\WebMessage;
use Symfony\Component\Notifier\Recipient\RecipientInterface;

interface WebNotificationInterface
{
    public function asWebMessage(RecipientInterface $recipient, ?string $transport = null): ?WebMessage;
}
