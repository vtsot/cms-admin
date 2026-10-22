<?php

declare(strict_types=1);

namespace App\Controller\Admin\Site;

use App\Entity\Review\MedicationTimeReviewQuestionItem;
use App\Security\Voter\Admin\Site\SiteReviewQuestionMedicationTimeVoter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SiteReviewQuestionMedicationTimeCrudController extends AbstractSiteRootCrudController
{
    protected function preList(Request $request): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SiteReviewQuestionMedicationTimeVoter::LIST,
            [$site, MedicationTimeReviewQuestionItem::class],
        );
    }

    protected function preShow(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SiteReviewQuestionMedicationTimeVoter::VIEW,
            [$site, $object],
        );
    }

    protected function preCreate(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SiteReviewQuestionMedicationTimeVoter::CREATE,
            [$site, MedicationTimeReviewQuestionItem::class],
        );
    }

    protected function preEdit(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SiteReviewQuestionMedicationTimeVoter::UPDATE,
            [$site, $object],
        );
    }

    protected function preDelete(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SiteReviewQuestionMedicationTimeVoter::DELETE,
            [$site, $object],
        );
    }
}
