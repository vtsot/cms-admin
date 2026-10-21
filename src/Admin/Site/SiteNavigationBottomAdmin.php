<?php

declare(strict_types=1);

namespace App\Admin\Site;

use App\Entity\Navigation\BottomNavigation;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;

/**
 * @method BottomNavigation|null getSubject()
 */
class SiteNavigationBottomAdmin extends AbstractSiteNavigationAdmin
{
    protected function configureListFields(ListMapper $list): void
    {
        parent::configureListFields($list);

        if ($list->has(ListMapper::NAME_ACTIONS)) {
            $list->remove(ListMapper::NAME_ACTIONS);

            $actions = [
                'children' => ['template' => 'admin/CRUD/list__action_children.html.twig'],
                'edit'     => [],
                'delete'   => [],
            ];
            $this->configureListFieldActions($list, $actions);
        }
    }

    protected function configureQuery(ProxyQueryInterface $query): ProxyQueryInterface
    {
        $alias = $query->getRootAliases()[0];
        $query->andWhere($alias . '.parent IS NULL');

        return $query;
    }
}
