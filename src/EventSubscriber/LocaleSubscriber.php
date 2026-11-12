<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Service\Request\ApiRequestDetector;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Translation\LocaleSwitcher;

use function in_array;
use function is_string;

readonly class LocaleSubscriber implements EventSubscriberInterface
{
    public function __construct(
        #[Autowire(param: 'default_locale')]
        private string $defaultLocale,
        #[Autowire(param: 'locales')]
        private array $locales,
        private LocaleSwitcher $localeSwitcher,
        private ApiRequestDetector $apiRequestDetector,
    ) {
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();
        $locale  = $this->apiRequestDetector->isApiRequest($request)
            ? $request->getPreferredLanguage($this->locales)
            : $request->attributes->get('_locale');

        // locale chosen with the admin global locale switcher, see sonata_translation.locale_switcher
        if ($locale === null && $request->hasPreviousSession()) {
            $locale = $request->getSession()->get('_locale');
        }

        // ignore unsupported or malformed values (e.g. a stale session locale or an arbitrary Accept-Language)
        if (!is_string($locale) || !in_array($locale, $this->locales, true)) {
            $locale = $this->defaultLocale;
        }

        $this->localeSwitcher->setLocale($locale);
        $request->setLocale($locale);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            // must be registered before (i.e. with a higher priority than) the default Locale listener
            KernelEvents::REQUEST => [['onKernelRequest', 10]],
        ];
    }
}
