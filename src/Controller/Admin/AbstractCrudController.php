<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Admin\AbstractAdmin;
use Sonata\AdminBundle\Controller\CRUDController;

abstract class AbstractCrudController extends CRUDController
{
    protected function addSuccessFlash(
        string $message,
        array $parameters = [],
        ?string $domain = null,
        ?string $locale = null,
    ): void {
        /** @var AbstractAdmin $admin */
        $admin = $this->admin->getRootAncestor();
        $domain ??= $admin->getTranslationDomain();
        $message = $this->trans($message, $parameters, $domain, $locale);

        $this->addFlash('sonata_flash_success', $message);
    }

    protected function addErrorFlash(
        string $message,
        array $parameters = [],
        ?string $domain = null,
        ?string $locale = null,
    ): void {
        /** @var AbstractAdmin $admin */
        $admin = $this->admin->getRootAncestor();
        $domain ??= $admin->getTranslationDomain();
        $message = $this->trans($message, $parameters, $domain, $locale);

        $this->addFlash('sonata_flash_error', $message);
    }
}
