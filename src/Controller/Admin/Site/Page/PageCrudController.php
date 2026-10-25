<?php

declare(strict_types=1);

namespace App\Controller\Admin\Site\Page;

use App\Controller\Admin\Site\AbstractSiteRootCrudController;
use App\Entity\Page\AbstractPage;
use App\Entity\Page\Page;
use App\Message\Command\Site\UpdateSiteHomepageCommand;
use App\Security\Voter\Admin\Site\PageVoter;
use App\Security\Voter\VoterSubject;
use App\Service\MessageBusHandler;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use function current;

class PageCrudController extends AbstractSiteRootCrudController
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

        if ($preResponse = $this->handlePreActionAccess(PageVoter::UPDATE, new VoterSubject($site->getId(), $page))) {
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
