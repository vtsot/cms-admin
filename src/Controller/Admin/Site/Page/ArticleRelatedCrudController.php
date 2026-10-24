<?php

declare(strict_types=1);

namespace App\Controller\Admin\Site\Page;

use App\Controller\Admin\Site\AbstractSiteRootCrudController;
use App\Entity\Page\PageRelatedArticle;
use App\Security\Voter\Admin\Site\PageRelatedArticleVoter;
use App\Security\Voter\VoterSubject;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleRelatedCrudController extends AbstractSiteRootCrudController
{
    protected function preList(Request $request): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            PageRelatedArticleVoter::LIST,
            new VoterSubject($site->getId(), PageRelatedArticle::class),
        );
    }

    protected function preShow(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            PageRelatedArticleVoter::VIEW,
            new VoterSubject($site->getId(), $object),
        );
    }

    protected function preCreate(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            PageRelatedArticleVoter::CREATE,
            new VoterSubject($site->getId(), PageRelatedArticle::class),
        );
    }

    protected function preEdit(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            PageRelatedArticleVoter::UPDATE,
            new VoterSubject($site->getId(), $object),
        );
    }

    protected function preDelete(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            PageRelatedArticleVoter::DELETE,
            new VoterSubject($site->getId(), $object),
        );
    }
}
