<?php

declare(strict_types=1);

namespace App\Controller\Admin\Site;

use App\Entity\Review\ProductReviewQuestionItem;
use App\Security\Voter\Admin\Site\SiteReviewQuestionProductVoter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SiteReviewQuestionProductCrudController extends AbstractSiteRootCrudController
{
    protected function preList(Request $request): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SiteReviewQuestionProductVoter::LIST,
            [$site, ProductReviewQuestionItem::class],
        );
    }

    protected function preShow(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SiteReviewQuestionProductVoter::VIEW,
            [$site, $object],
        );
    }

    protected function preCreate(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SiteReviewQuestionProductVoter::CREATE,
            [$site, ProductReviewQuestionItem::class],
        );
    }

    protected function preEdit(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SiteReviewQuestionProductVoter::UPDATE,
            [$site, $object],
        );
    }

    protected function preDelete(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SiteReviewQuestionProductVoter::DELETE,
            [$site, $object],
        );
    }
}
