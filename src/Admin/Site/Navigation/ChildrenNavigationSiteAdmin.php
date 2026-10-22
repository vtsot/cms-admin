<?php

declare(strict_types=1);

namespace App\Admin\Site\Navigation;

use App\Entity\Navigation\AbstractNavigation;

/**
 * @method AbstractNavigation|null getSubject()
 */
class ChildrenNavigationSiteAdmin extends AbstractNavigationSiteAdmin
{
    protected function prePersist(object $object): void
    {
        $object->setSite($this->getRootAncestor()->getSubject());
    }

    protected function preUpdate(object $object): void
    {
        $object->setSite($this->getRootAncestor()->getSubject());
    }
}
