<?php

declare(strict_types=1);

namespace App\Controller\Admin\Site;

use App\Entity\Faq\Faq;
use App\Security\Voter\Admin\Site\SiteFaqVoter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SiteFaqCrudController extends AbstractSiteRootCrudController
{
    protected function preList(Request $request): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SiteFaqVoter::LIST,
            [$site, Faq::class],
        );
    }

    protected function preShow(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SiteFaqVoter::VIEW,
            [$site, $object],
        );
    }

    protected function preCreate(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SiteFaqVoter::CREATE,
            [$site, Faq::class],
        );
    }

    protected function preEdit(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SiteFaqVoter::UPDATE,
            [$site, $object],
        );
    }

    protected function preDelete(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SiteFaqVoter::DELETE,
            [$site, $object],
        );
    }
}
