<?php

declare(strict_types=1);

namespace App\Controller\Admin\Site\Navigation;

use App\Controller\Admin\Site\AbstractSiteRootCrudController;
use App\Entity\Navigation\MainNavigation;
use App\Security\Voter\Admin\Site\Navigation\MainNavigationSiteVoter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MainNavigationSiteCrudController extends AbstractSiteRootCrudController
{
    protected function preList(Request $request): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            MainNavigationSiteVoter::LIST,
            [$site, MainNavigation::class],
        );
    }

    protected function preShow(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            MainNavigationSiteVoter::VIEW,
            [$site, $object],
        );
    }

    protected function preCreate(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            MainNavigationSiteVoter::CREATE,
            [$site, MainNavigation::class],
        );
    }

    protected function preEdit(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            MainNavigationSiteVoter::UPDATE,
            [$site, $object],
        );
    }

    protected function preDelete(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            MainNavigationSiteVoter::DELETE,
            [$site, $object],
        );
    }
}
