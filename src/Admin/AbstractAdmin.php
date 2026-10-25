<?php

declare(strict_types=1);

namespace App\Admin;

use App\Contract\Entity\EntityInterface;
use App\Contract\Entity\UserInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin as BaseAbstractAdmin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\TranslationBundle\Provider\LocaleProviderInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Intl\Exception\MissingResourceException;
use Symfony\Component\Intl\Languages;
use Symfony\Component\Intl\Locales;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Contracts\Service\Attribute\Required;

use function count;
use function is_object;
use function str_replace;

/**
 * @method EntityInterface getSubject()
 */
abstract class AbstractAdmin extends BaseAbstractAdmin
{
    protected const string CK_EDITOR_BASE_CONFIG = 'base-config';
    protected const string CK_EDITOR_CMS_CONFIG  = 'cms-config';

    protected Security $security;
    protected RouterInterface $routeGenerator;
    protected TokenStorageInterface $tokenStorage;

    protected $baseRouteName;
    protected $baseRoutePattern;

    protected string $defaultLocale = 'en_GB';
    protected array $locales        = [];
    protected LocaleProviderInterface $translationLocaleProvider;

    #[Required]
    public function init(
        Security $security,
        RouterInterface $routeGenerator,
        TokenStorageInterface $tokenStorage,

        #[Autowire(param: 'default_locale')]
        string $defaultLocale,

        #[Autowire(param: 'locales')]
        array $locales,

        #[Autowire(service: 'sonata_translation.admin.provider.request_locale_provider')]
        LocaleProviderInterface $translationLocaleProvider,
    ): void {
        $this->security                  = $security;
        $this->routeGenerator            = $routeGenerator;
        $this->tokenStorage              = $tokenStorage;
        $this->defaultLocale             = $defaultLocale;
        $this->locales                   = $locales;
        $this->translationLocaleProvider = $translationLocaleProvider;
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection->remove('show');
        $collection->remove('export');
    }

    public function generateInfinityChildListUrl(AdminInterface $admin, EntityInterface $object): string
    {
        $routes = $admin->getRoutes();
        $route  = $routes->get('list');
        $id     = $admin->getNormalizedIdentifier($object);

        // return child url
        return $this->routeGenerator->generate($route->getDefault('_sonata_name'), ['id' => $id]);
    }

    public function generateChildListUrl(AdminInterface $admin, EntityInterface $object): string
    {
        $routes = $admin->getRoutes();
        $route  = $routes->get('list');

        $currAdmin  = clone $admin;
        $treeAdmins = [];

        while ($currAdmin->isChild()) {
            $currAdmin    = $currAdmin->getParent();
            $treeAdmins[] = $currAdmin;
        }

        $key         = '';
        $routeParams = [];

        foreach (array_reverse($treeAdmins) as $index => $treeAdmin) {
            if ($index === 0) {
                $routeParams['id'] = $treeAdmin->hasSubject()
                    ? $admin->getNormalizedIdentifier($treeAdmin->getSubject())
                    : $admin->getNormalizedIdentifier($object);
            } else {
                $key .= $index === 1 ? 'childId' : 'ChildId';
                $routeParams[$key] = $admin->getNormalizedIdentifier($object);
            }
        }

        return $this->routeGenerator->generate($route->getDefault('_sonata_name'), $routeParams);
    }

    public function generateChildEditUrl(
        AdminInterface $admin,
        EntityInterface $parent,
        EntityInterface $object,
    ): string {
        $routes   = $admin->getRoutes();
        $route    = $routes->get('edit');
        $parentId = $admin->getNormalizedIdentifier($parent);
        $id       = $admin->getNormalizedIdentifier($object);

        // return edit child url
        return $this->routeGenerator
            ->generate(
                $route->getDefault('_sonata_name'),
                ['id' => $parentId, 'childId' => $id]
            );
    }

    public function setBaseRouteName(string $baseRouteName): void
    {
        $this->baseRouteName = $baseRouteName;
    }

    protected function generateBaseRouteName(bool $isChildAdmin = false): string
    {
        return $this->baseRouteName ?? parent::generateBaseRouteName($isChildAdmin);
    }

    public function setBaseRoutePattern(string $baseRoutePattern): void
    {
        $this->baseRoutePattern = $baseRoutePattern;
    }

    protected function generateBaseRoutePattern(bool $isChildAdmin = false): string
    {
        return $this->baseRoutePattern ?? parent::generateBaseRoutePattern($isChildAdmin);
    }

    protected function getUser(): ?UserInterface
    {
        $token = $this->tokenStorage->getToken();

        if ($token === null || !is_object($user = $token->getUser()) || !$user instanceof UserInterface) {
            return null;
        }

        return $user;
    }

    protected function trans(
        string $id,
        array $parameters = [],
        ?string $domain = null,
        ?string $locale = null,
    ): string {
        if ($domain === null) {
            $domain = $this->getTranslationDomain();
        }

        return $this->getTranslator()->trans($id, $parameters, $domain, $locale);
    }

    protected function transLocaleTitle(
        string $id,
        array $parameters = [],
        ?string $domain = null,
        ?string $locale = null,
    ): string {
        static $countLocales = null;

        if ($countLocales === null) {
            $countLocales = count($this->locales);
        }

        if ($domain === null) {
            $domain = $this->getTranslationDomain();
        }

        $parameters = array_merge($parameters, ['%LOCALE%' => '', '%LANG%' => '']);

        if ($countLocales > 1) {
            try {
                $localeName = Locales::getName($this->translationLocaleProvider->get(), $this->defaultLocale);
                $langName   = Languages::getName($this->translationLocaleProvider->get(), $this->defaultLocale);
            } catch (MissingResourceException) {
                $localeName = $this->translationLocaleProvider->get();
                $langName   = '';
            }

            $parameters = array_merge($parameters, [
                '%LOCALE%' => $localeName,
                '%LANG%'   => $langName,
            ]);
        }

        $translation = $this->trans($id, $parameters, $domain, $locale);

        if ($countLocales <= 1) {
            $translation = str_replace(['%LOCALE%', '%LANG%', ':', "'", '"'], '', $translation);
        }

        return $translation;
    }
}
