<?php

declare(strict_types=1);

namespace App\Controller\Admin\Site;

use App\Entity\Navigation\AbstractNavigation;
use App\Security\Voter\Admin\Site\NavigationVoter;
use App\Security\Voter\VoterSubject;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NavigationSiteCrudController extends AbstractSiteRootCrudController
{
    protected function preList(Request $request): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            NavigationVoter::LIST,
            new VoterSubject($site->getId(), AbstractNavigation::class)
        );
    }

    protected function preShow(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            NavigationVoter::VIEW,
            new VoterSubject($site->getId(), $object),
        );
    }

    protected function preCreate(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            NavigationVoter::CREATE,
            new VoterSubject($site->getId(), AbstractNavigation::class),
        );
    }

    protected function preEdit(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            NavigationVoter::UPDATE,
            new VoterSubject($site->getId(), $object),
        );
    }

    protected function preDelete(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            NavigationVoter::DELETE,
            new VoterSubject($site->getId(), $object),
        );
    }
}
