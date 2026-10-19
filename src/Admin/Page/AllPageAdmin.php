<?php

declare(strict_types=1);

namespace App\Admin\Page;

use App\Admin\Traits\ConfigureListTrait;
use App\Entity\Page\AbstractPage;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;

/**
 * @method AbstractPage|null getSubject()
 */
class AllPageAdmin extends AbstractPageAdmin
{
    use ConfigureListTrait;

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
        $collection->clearExcept(['list']);
    }

    protected function configureListFields(ListMapper $list): void
    {
        parent::configureListFields($list);

        $list->remove('active');
        $list->remove(ListMapper::NAME_ACTIONS);
    }
}
