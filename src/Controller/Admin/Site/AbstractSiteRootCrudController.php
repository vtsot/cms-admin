<?php

declare(strict_types=1);

namespace App\Controller\Admin\Site;

use App\Admin\AbstractAdmin;
use App\Controller\Admin\AbstractCrudController;
use App\Entity\Site\Site;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Service\Attribute\Required;

use function sprintf;

abstract class AbstractSiteRootCrudController extends AbstractCrudController
{
    protected Security $security;

    #[Required]
    public function initSecurity(
        Security $security,
    ): void {
        $this->security = $security;
    }

    protected function resolveSiteFromRootRequest(Request $request): Site
    {
        /** @var AbstractAdmin $admin */
        $admin    = $this->admin->getRootAncestor();
        $objectId = $request->attributes->get($admin->getIdParameter());
        $site     = $admin->getObject($objectId);

        if (!$site instanceof Site) {
            throw $this->createNotFoundException(
                sprintf(
                    'Unable to find %s object with id: %s.',
                    $admin->getClassnameLabel(),
                    $objectId
                )
            );
        }

        return $site;
    }

    protected function handlePreActionAccess(
        string $attribute,
        array $subject,
    ): ?Response {
        if (!$this->security->isGranted($attribute, $subject)) {
            $this->addErrorFlash('FLASH.ERROR.NO_PERMISSION');

            return $this->redirectToRoute('admin.site_list');
        }

        return null;
    }
}
