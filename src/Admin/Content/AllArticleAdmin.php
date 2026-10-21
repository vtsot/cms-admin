<?php

declare(strict_types=1);

namespace App\Admin\Content;

use App\Admin\Traits\ConfigureFilterAutocompleteSitesTrait;
use App\Admin\Traits\ConfigureListTrait;
use App\Entity\Page\Article;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;

/**
 * @method Article|null getSubject()
 */
class AllArticleAdmin extends AbstractPageAdmin
{
    use ConfigureListTrait;
    use ConfigureFilterAutocompleteSitesTrait;

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues = [
            '_sort_order' => 'ASC',
            '_sort_by'    => 'slug',
        ];
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        parent::configureRoutes($collection);
        $collection->clearExcept(['list', 'edit']);
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $this->configureFilterFieldAutocompleteSites($filter, 'site');
        parent::configureDatagridFilters($filter);
    }

    protected function configureListFields(ListMapper $list): void
    {
        // parent::configureListFields($list);
        $this->configureListFieldActive(
            list: $list,
            name: 'active',
            options: ['editable' => false],
        );

        $this->configureListFieldText(
            $list,
            'site.domain',
            'SITE_ENTITY.LABEL.DOMAIN',
        );

        $this->configureListFieldText(
            $list,
            'slug',
            'PAGE_ENTITY.LABEL.SLUG',
        );

        $this->configureListFieldText(
            $list,
            'title',
            'PAGE_ENTITY.LABEL.TITLE',
            ['identifier' => true, 'route' => ['name' => 'edit']],
        );

        $this->configureListFieldChangedAt($list);
        $this->configureListFieldActions(list: $list, actions: ['edit' => []]);
        // $list->remove(ListMapper::NAME_ACTIONS);
    }
}
