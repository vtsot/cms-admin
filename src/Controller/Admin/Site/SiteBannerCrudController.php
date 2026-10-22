<?php

declare(strict_types=1);

namespace App\Controller\Admin\Site;

use App\Entity\Banner;
use App\Security\Voter\Admin\Site\SiteBannerVoter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SiteBannerCrudController extends AbstractSiteRootCrudController
{
    protected function preList(Request $request): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SiteBannerVoter::LIST,
            [$site, Banner::class],
        );
    }

    protected function preShow(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SiteBannerVoter::VIEW,
            [$site, $object],
        );
    }

    protected function preCreate(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SiteBannerVoter::CREATE,
            [$site, Banner::class],
        );
    }

    protected function preEdit(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SiteBannerVoter::UPDATE,
            [$site, $object],
        );
    }

    protected function preDelete(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SiteBannerVoter::DELETE,
            [$site, $object],
        );
    }
}
