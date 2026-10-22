<?php

declare(strict_types=1);

namespace App\Controller\Admin\Site\Page;

use App\Controller\Admin\Site\AbstractSiteRootCrudController;
use App\Entity\Page\PageRelatedArticle;
use App\Security\Voter\Admin\Site\SitePageRelatedArticleVoter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SitePageRelatedArticleCrudController extends AbstractSiteRootCrudController
{
    protected function preList(Request $request): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SitePageRelatedArticleVoter::LIST,
            [$site, PageRelatedArticle::class],
        );
    }

    protected function preShow(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SitePageRelatedArticleVoter::VIEW,
            [$site, $object],
        );
    }

    protected function preCreate(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SitePageRelatedArticleVoter::CREATE,
            [$site, PageRelatedArticle::class],
        );
    }

    protected function preEdit(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SitePageRelatedArticleVoter::UPDATE,
            [$site, $object],
        );
    }

    protected function preDelete(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SitePageRelatedArticleVoter::DELETE,
            [$site, $object],
        );
    }
}
