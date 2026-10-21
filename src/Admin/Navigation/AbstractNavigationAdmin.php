<?php

declare(strict_types=1);

namespace App\Admin\Navigation;

use App\Admin\AbstractAdmin;
use App\Admin\Traits\ConfigureAdminFullTrait;
use App\Entity\Navigation\AbstractNavigation;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * @method AbstractNavigation|null getSubject()
 */
abstract class AbstractNavigationAdmin extends AbstractAdmin
{
    use ConfigureAdminFullTrait;

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues = [
            '_sort_order' => 'ASC',
            '_sort_by'    => 'position',
        ];
    }

    protected function configureQuery(ProxyQueryInterface $query): ProxyQueryInterface
    {
        /** @var ProxyQueryInterface|QueryBuilder $query */
        $query = parent::configureQuery($query);

        if ($this->isChild() === false) {
            $alias = $query->getRootAliases()[0];
            $query->andWhere($alias . '.parent IS NULL');
        }

        return $query;
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $this->configureFilterFieldText($filter, 'title', 'NAVIGATION_ENTITY.LABEL.TITLE');
        $this->configureFilterFieldActive($filter);

        $this->configureFilterFieldCreatedAtDateRange($filter);
        $this->configureFilterFieldUpdatedAtDateRange($filter);
    }

    protected function configureListFields(ListMapper $list): void
    {
        $this->configureListFieldPosition($list);

        $optionsEdit = ['identifier' => true, 'route' => ['name' => 'edit']];
        $this->configureListFieldText($list, 'title', 'NAVIGATION_ENTITY.LABEL.TITLE', $optionsEdit);

        $this->configureListFieldLinkEntity($list, 'linkUrl');

        $this->configureListFieldActive($list);
        $this->configureListFieldChangedAt($list);

        $this->configureListFieldChildrenActions(
            list: $list,
            actions: [
                'children' => ['template' => 'admin/CRUD/list__action_children_infinity.html.twig'],
                'edit'     => [],
                'delete'   => [],
            ],
            width: '300px'
        );
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form->with('NAVIGATION_ENTITY.SECTION.MAIN');

        $this->configureFormFieldText($form, 'title', 'NAVIGATION_ENTITY.LABEL.TITLE');
        $this->configureFormFieldLinkEntity($form);

        $form->end();
    }
}
