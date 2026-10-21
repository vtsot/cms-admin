<?php

declare(strict_types=1);

namespace App\Controller\Admin\Site;

use App\Entity\Review\ReasonReviewQuestionItem;
use App\Security\Voter\Admin\SiteReviewQuestionReasonVoter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SiteReviewQuestionReasonCrudController extends AbstractSiteRootCrudController
{
    protected function preList(Request $request): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SiteReviewQuestionReasonVoter::LIST,
            [$site, ReasonReviewQuestionItem::class],
        );
    }

    protected function preShow(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SiteReviewQuestionReasonVoter::VIEW,
            [$site, $object],
        );
    }

    protected function preCreate(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SiteReviewQuestionReasonVoter::CREATE,
            [$site, ReasonReviewQuestionItem::class],
        );
    }

    protected function preEdit(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SiteReviewQuestionReasonVoter::UPDATE,
            [$site, $object],
        );
    }

    protected function preDelete(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SiteReviewQuestionReasonVoter::DELETE,
            [$site, $object],
        );
    }
}
