<?php

declare(strict_types=1);

namespace App\Admin\Site\Navigation;

use App\Admin\Navigation\AbstractNavigationAdmin;
use App\Admin\Traits\RelatedToSite\ConfigureFormFieldLinkEntityRelatedToSiteTrait;
use Exception;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;

abstract class AbstractNavigationSiteAdmin extends AbstractNavigationAdmin
{
    use ConfigureFormFieldLinkEntityRelatedToSiteTrait;

    protected function configureQuery(ProxyQueryInterface $query): ProxyQueryInterface
    {
        try {
            $isTopLevelSiteNavigation = $this->getParent()->getCode() === 'admin.site';
        } catch (Exception $e) {
            $isTopLevelSiteNavigation = false;
        }

        if ($isTopLevelSiteNavigation) {
            $alias = $query->getRootAliases()[0];
            $query->andWhere($alias . '.parent IS NULL');
        }

        return $query;
    }

    protected function isGrantedChildrenNavigation(?string $attributes = 'LIST'): bool
    {
        foreach ($this->getRootAncestor()->getChildren() as $child) {
            if ($child instanceof (self::class)) {
                return $this->getSecurityHandler()->isGranted($child, $attributes);
            }
        }

        return false;
    }

    protected function configureListFields(ListMapper $list): void
    {
        parent::configureListFields($list);

        if ($list->has(ListMapper::NAME_ACTIONS)) {
            $list->remove(ListMapper::NAME_ACTIONS);

            $actions = $this->isGrantedChildrenNavigation()
                ? [
                    'children' => ['template' => 'admin/CRUD/site/list__action_navigation_children.html.twig'],
                    'edit'     => [],
                    'delete'   => [],
                ] : [
                    'edit'   => [],
                    'delete' => [],
                ];

            $this->configureListFieldChildrenActions(list: $list, actions: $actions, width: '300px');
        }
    }
}
