<?php

declare(strict_types=1);

namespace App\Admin\Site;

use App\Entity\Navigation\AbstractNavigation;
use Sonata\AdminBundle\Datagrid\ListMapper;

/**
 * @method AbstractNavigation|null getSubject()
 */
class SiteNavigationChildrenAdmin extends AbstractSiteNavigationAdmin
{
    protected function configureListFields(ListMapper $list): void
    {
        parent::configureListFields($list);

        if ($list->has(ListMapper::NAME_ACTIONS)) {
            $list->remove(ListMapper::NAME_ACTIONS);
            $this->configureListFieldActions($list);
        }
    }

    protected function prePersist(object $object): void
    {
        $object->setSite($this->getRootAncestor()->getSubject());
    }

    protected function preUpdate(object $object): void
    {
        $object->setSite($this->getRootAncestor()->getSubject());
    }
}
