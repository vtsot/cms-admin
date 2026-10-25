<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Translation\LocaleSwitcher;

readonly class LocaleSubscriber implements EventSubscriberInterface
{
    public function __construct(
        #[Autowire(param: 'api_domain')]
        private string $apiDomain,
        #[Autowire(param: 'default_locale')]
        private string $defaultLocale,
        private LocaleSwitcher $localeSwitcher,
    ) {
    }

    // todo: move to external service
    private function isApiRequest(RequestEvent $event): bool
    {
        $request = $event->getRequest();

        return $request->isXmlHttpRequest()
            || $request->getContentTypeFormat() === 'json'
            || $request->getHost() === $this->apiDomain
            || in_array('application/json', $request->getAcceptableContentTypes(), true)
            || str_contains($request->getPathInfo(), '/api/');
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $locale  = $this->isApiRequest($event)
            ? $request->getPreferredLanguage()
            : $request->attributes->get('_locale');

        // locale chosen with the admin global locale switcher, see sonata_translation.locale_switcher
        if ($locale === null && $request->hasPreviousSession()) {
            $locale = $request->getSession()->get('_locale');
        }

        if ($locale === null) {
            $locale = $this->defaultLocale;
        }

        $this->localeSwitcher->setLocale($locale);
        $request->setLocale($locale);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            // must be registered before (i.e. with a higher priority than) the default Locale listener
            KernelEvents::REQUEST => [['onKernelRequest', 20]],
        ];
    }
}
