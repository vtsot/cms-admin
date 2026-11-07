<?php

declare(strict_types=1);

namespace App\Admin\Site;

use App\Admin\AbstractAdmin;
use App\Admin\Traits\ConfigureAdminFullTrait;
use App\Admin\Traits\ConfigureFilterAutocompleteSitesTrait;
use App\Entity\Site\Contact;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;

/**
 * @method Contact|null getSubject()
 */
class ContactAdmin extends AbstractAdmin
{
    use ConfigureAdminFullTrait;
    use ConfigureFilterAutocompleteSitesTrait;

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues = [
            '_sort_order' => 'DESC',
            '_sort_by'    => 'createdAt',
        ];
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        parent::configureRoutes($collection);
        $collection->remove('create');
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $this->configureFilterFieldText($filter, 'context', 'CONTACT_ENTITY.LABEL.CONTEXT');
    }

    protected function configureListFields(ListMapper $list): void
    {
        $this->configureListFieldText($list, 'site.domain', 'CONTACT_ENTITY.LABEL.SITE');
        $this->configureListFieldText(
            $list,
            'context-virtual',
            'CONTACT_ENTITY.LABEL.CONTEXT',
            [
                'virtual_field' => true,
                'template'      => 'admin/CRUD/site-contact/list__context.html.twig',
            ]
        );

        $this->configureListFieldChangedAt($list);
        $this->configureListFieldActions($list, ['delete' => []]);
    }
}
