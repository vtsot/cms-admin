<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Uid\Uuid;

class JWTDecodedListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            Events::JWT_DECODED => 'onJWTDecoded',
        ];
    }

    public function onJWTDecoded(JWTDecodedEvent $event): void
    {
        $payload = $event->getPayload();

        if (!isset($payload['userId'], $payload['siteId'], $payload['token'])
            || !Uuid::isValid($payload['userId'])
            || !Uuid::isValid($payload['siteId'])
        ) {
            $event->markAsInvalid();
        }
    }
}
