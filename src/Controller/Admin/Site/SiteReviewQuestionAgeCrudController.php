<?php

declare(strict_types=1);

namespace App\Controller\Admin\Site;

use App\Entity\Review\AgeReviewQuestionItem;
use App\Security\Voter\Admin\SiteReviewQuestionAgeVoter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SiteReviewQuestionAgeCrudController extends AbstractSiteRootCrudController
{
    protected function preList(Request $request): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SiteReviewQuestionAgeVoter::LIST,
            [$site, AgeReviewQuestionItem::class],
        );
    }

    protected function preShow(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SiteReviewQuestionAgeVoter::VIEW,
            [$site, $object],
        );
    }

    protected function preCreate(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SiteReviewQuestionAgeVoter::CREATE,
            [$site, AgeReviewQuestionItem::class],
        );
    }

    protected function preEdit(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SiteReviewQuestionAgeVoter::UPDATE,
            [$site, $object],
        );
    }

    protected function preDelete(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SiteReviewQuestionAgeVoter::DELETE,
            [$site, $object],
        );
    }
}
