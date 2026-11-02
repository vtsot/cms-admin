<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Security\Authentication\ApiSiteLoginAuthenticator;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;

final readonly class JWTCreatedListener implements EventSubscriberInterface
{
    public function __construct(
        private RequestStack $requestStack,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            Events::JWT_CREATED => 'onJWTCreated',
        ];
    }

    public function onJWTCreated(JWTCreatedEvent $event): void
    {
        $request = $this->requestStack->getMainRequest();
        $payload = $event->getData();

        $payload['siteId'] = $request?->headers->get(ApiSiteLoginAuthenticator::HEADER_SITE_ID);
        $payload['token']  = $request?->headers->get(ApiSiteLoginAuthenticator::HEADER_SITE_TOKEN);

        $event->setData($payload);
    }
}
