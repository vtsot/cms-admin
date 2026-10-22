<?php

declare(strict_types=1);

namespace App\Controller\Admin\Site;

use App\CQ\Command\Site\UpdateSiteHomepageCommand;
use App\Entity\Page\Page;
use App\Security\Voter\Admin\Site\SitePageVoter;
use App\Service\MessageBusHandler;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use function current;

class SitePageCrudController extends AbstractSiteRootCrudController
{
    public function __construct(
        private readonly MessageBusHandler $messageBusHandler,
    ) {
    }

    public function makeHomepageAction(Request $request): Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        /** @var Page $page */
        $page = $this->assertObjectExists($request, true);

        if (!$page) {
            $this->addErrorFlash('PAGE_ENTITY.FLASH.ERROR.NOT_FOUND');

            return $this->redirectToList();
        }

        if ($preResponse = $this->handlePreActionAccess(SitePageVoter::UPDATE, [$site, $page])) {
            return $preResponse;
        }

        // set page as homepage
        $this->messageBusHandler->handleCommand(new UpdateSiteHomepageCommand($site->getId(), $page->getId()));

        $this->addSuccessFlash(
            $this->trans(
                'PAGE_ENTITY.FLASH.SUCCESS.MAKE_HOMEPAGE',
                ['{TITLE}' => $page->getTitle() ?: $page->getSlug()],
            ),
        );

        return $this->redirectToList();
    }

    protected function preList(Request $request): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SitePageVoter::LIST,
            [$site, Page::class],
        );
    }

    protected function preShow(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SitePageVoter::VIEW,
            [$site, $object],
        );
    }

    protected function preCreate(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SitePageVoter::CREATE,
            [$site, Page::class],
        );
    }

    protected function preEdit(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SitePageVoter::UPDATE,
            [$site, $object],
        );
    }

    protected function preDelete(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SitePageVoter::DELETE,
            [$site, $object],
        );
    }

    public function batchActionDelete(ProxyQueryInterface $query): Response
    {
        /** @var ProxyQueryInterface|QueryBuilder $query */
        $alias = current($query->getRootAliases());

        // exclude homepage
        $query
            ->andWhere("{$alias}.homepage = :is_homepage")
            ->setParameter('is_homepage', false);

        return parent::batchActionDelete($query);
    }
}
