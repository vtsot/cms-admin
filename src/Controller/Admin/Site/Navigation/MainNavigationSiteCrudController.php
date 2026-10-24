<?php

declare(strict_types=1);

namespace App\Controller\Admin\Site\Navigation;

use App\Controller\Admin\Site\AbstractSiteRootCrudController;
use App\Entity\Navigation\AbstractNavigation;
use App\Security\Voter\Admin\Site\MainNavigationSiteVoter;
use App\Security\Voter\VoterSubject;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MainNavigationSiteCrudController extends AbstractSiteRootCrudController
{
    protected function preList(Request $request): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            MainNavigationSiteVoter::LIST,
            new VoterSubject($site->getId(), AbstractNavigation::class)
        );
    }

    protected function preShow(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            MainNavigationSiteVoter::VIEW,
            new VoterSubject($site->getId(), $object),
        );
    }

    protected function preCreate(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            MainNavigationSiteVoter::CREATE,
            new VoterSubject($site->getId(), AbstractNavigation::class),
        );
    }

    protected function preEdit(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            MainNavigationSiteVoter::UPDATE,
            new VoterSubject($site->getId(), $object),
        );
    }

    protected function preDelete(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            MainNavigationSiteVoter::DELETE,
            new VoterSubject($site->getId(), $object),
        );
    }
}
