<?php

declare(strict_types=1);

namespace App\Controller\Admin\Site;

use App\Controller\Admin\AbstractCrudController;
use App\CQ\Command\Site\ResetSiteTokenCommand;
use App\CQ\Command\Site\SiteCacheClearCommand;
use App\Entity\Site\Site;
use App\Entity\Site\SiteSettings;
use App\Service\MessageBusHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

use function assert;

class SiteCrudController extends AbstractCrudController
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly MessageBusHandler $messageBusHandler,
    ) {
    }

    public function tokenResetAction(Request $request): Response
    {
        /** @var Site $object */
        $object = $this->assertObjectExists($request, true);
        assert($object !== null);

        $this->checkParentChildAssociation($request, $object);

        $this->admin->checkAccess('token-reset', $object);

        if ($request->getMethod() === Request::METHOD_POST) {
            // check the csrf token
            $this->validateCsrfToken($request, 'site.token-reset');

            $objectName = $this->admin->toString($object);

            try {
                $this->messageBusHandler->handleCommand(new ResetSiteTokenCommand($object->getId()));

                if ($this->isXmlHttpRequest($request)) {
                    return $this->renderJson(['result' => 'ok']);
                }

                $this->addSuccessFlash(
                    'SITE_ENTITY.TOKEN_RESET.FLASH.SUCCESS',
                    ['%object%' => $this->escapeHtml($objectName)]
                );
            } catch (Throwable $e) {
                $this->addErrorFlash(
                    'SITE_ENTITY.TOKEN_RESET.FLASH.ERROR',
                    ['%object%' => $this->escapeHtml($objectName)]
                );
            }

            return $this->redirectToList();
        }

        return $this->render(
            'admin/CRUD/site/token-reset.html.twig',
            [
                'object'     => $object,
                'action'     => 'token-reset',
                'csrf_token' => $this->getCsrfToken('site.token-reset'),
            ]
        );
    }

    public function settingsAction(Request $request): Response
    {
        /** @var Site $object */
        $object = $this->assertObjectExists($request, true);
        assert($object !== null);

        $this->checkParentChildAssociation($request, $object);

        $this->admin->checkAccess('settings', $object);

        $settings = $object->getSettings();

        if ($settings === null) {
            $settings = new SiteSettings()->setSite($object);
            $this->em->persist($settings);
            $this->em->flush();
        }

        return $this->redirectToRoute(
            'admin.site_admin.site.settings_edit',
            [
                'id'      => $object->getId()?->toString(),
                'childId' => $settings->getId()?->toString(),
            ]
        );
    }

    public function cacheClearAction(Request $request): Response
    {
        /** @var Site $object */
        $object = $this->assertObjectExists($request, true);
        assert($object !== null);

        $this->checkParentChildAssociation($request, $object);

        $this->admin->checkAccess('cache-clear', $object);

        $objectName = $this->admin->toString($object);

        try {
            $this->messageBusHandler->handleCommand(new SiteCacheClearCommand($object->getDomain(), $object->getToken()));

            $this->addSuccessFlash(
                'SITE_ENTITY.CACHE_CLEAR.FLASH.SUCCESS',
                ['%object%' => $this->escapeHtml($objectName)]
            );
        } catch (Throwable $e) {
            $this->addErrorFlash(
                'SITE_ENTITY.CACHE_CLEAR.FLASH.ERROR',
                ['%object%' => $this->escapeHtml($objectName)]
            );
        }

        return $this->redirectToList();
    }
}
