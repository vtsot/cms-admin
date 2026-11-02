<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\RateLimiter\RateLimiterFactoryInterface;

use function max;
use function time;

readonly class ApiRequestLimiterSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private RateLimiterFactoryInterface $apiRequestLimiter,

        #[Autowire(param: 'api_domain')]
        private string $apiDomain,
    ) {
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        // checks the host, not ApiRequestDetector: that also matches admin XHR and /api/cms-embeds
        if (!$event->isMainRequest() || $request->getHost() !== $this->apiDomain) {
            return;
        }

        $limit = $this->apiRequestLimiter->create($request->getClientIp())->consume();

        if (!$limit->isAccepted()) {
            throw new TooManyRequestsHttpException(max(1, $limit->getRetryAfter()->getTimestamp() - time()), 'Too many requests.');
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            // before the router (32) and the firewall (8), so rejected requests stay cheap
            KernelEvents::REQUEST => ['onKernelRequest', 64],
        ];
    }
}
