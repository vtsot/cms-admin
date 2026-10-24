<?php

declare(strict_types=1);

namespace App\Controller\Admin\Site\Page;

use App\Controller\Admin\Site\AbstractSiteRootCrudController;
use App\Entity\Page\AbstractPage;
use App\Security\Voter\Admin\Site\PageVoter;
use App\Security\Voter\VoterSubject;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleCrudController extends AbstractSiteRootCrudController
{
    protected function preList(Request $request): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            PageVoter::LIST,
            new VoterSubject($site->getId(), AbstractPage::class),
        );
    }

    protected function preShow(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            PageVoter::VIEW,
            new VoterSubject($site->getId(), $object),
        );
    }

    protected function preCreate(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            PageVoter::CREATE,
            new VoterSubject($site->getId(), AbstractPage::class),
        );
    }

    protected function preEdit(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            PageVoter::UPDATE,
            new VoterSubject($site->getId(), $object),
        );
    }

    protected function preDelete(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            PageVoter::DELETE,
            new VoterSubject($site->getId(), $object),
        );
    }
}
