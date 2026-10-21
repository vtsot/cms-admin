<?php

declare(strict_types=1);

namespace App\Admin;

use App\Contract\Entity\EntityInterface;
use App\Contract\Entity\UserInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin as BaseAbstractAdmin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Contracts\Service\Attribute\Required;

use function is_object;
use function sprintf;
use function str_replace;
use function strtoupper;

/**
 * @method EntityInterface getSubject()
 */
abstract class AbstractAdmin extends BaseAbstractAdmin
{
    protected const CK_EDITOR_BASE_CONFIG        = 'base-config';
    protected const CK_EDITOR_CMS_CONFIG         = 'cms-config';
    protected const CK_EDITOR_FAQ_CONFIG         = 'faq-config';
    protected const CK_EDITOR_DESCRIPTION_CONFIG = 'description';

    protected TokenStorageInterface $tokenStorage;
    protected ParameterBagInterface $parameterBag;
    protected RouterInterface $routeGenerator;
    protected Security $security;

    protected $baseRouteName;
    protected $baseRoutePattern;

    #[Required]
    public function init(
        TokenStorageInterface $tokenStorage,
        ParameterBagInterface $parameterBag,
        RouterInterface $routeGenerator,
        Security $security,
    ): void {
        $this->tokenStorage   = $tokenStorage;
        $this->parameterBag   = $parameterBag;
        $this->routeGenerator = $routeGenerator;
        $this->security       = $security;

        $this->setTranslationDomain($this->parameterBag->get('admin_translation_domain'));
    }

    protected function configure(): void
    {
        // resolve breadcrumb translation key
        $this->classnameLabel = strtoupper(
            sprintf(
                'BREADCRUMB.%s.%s',
                str_replace('.', '_', $this->getLabel()),
                $this->classnameLabel
            )
        );
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

    protected function isAdminRoute(string $name, ?string $adminCode = null): bool
    {
        if ($adminCode === null) {
            $adminCode = $this->getRequest()->get('_sonata_admin');
        }

        $adminRoute = $this->getRequest()->get('_sonata_name');

        if ($adminCode !== null && $adminRoute !== null) {
            return $adminRoute === $adminCode . '_' . $name;
        }

        return false;
    }

    public function getCurrentRouteName(): string
    {
        return str_replace($this->getBaseCodeRoute() . '_', '', $this->getRequest()->get('_route'));
    }
}
