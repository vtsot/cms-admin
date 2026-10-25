<?php

declare(strict_types=1);

namespace App\Admin\Navigation;

use App\Admin\AbstractAdmin;
use App\Admin\Navigation\Contract\NavigationAdminInterface;
use App\Admin\Traits\ConfigureAdminFullTrait;
use App\Entity\Navigation\AbstractNavigation;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * @method AbstractNavigation|null getSubject()
 */
abstract class AbstractNavigationAdmin extends AbstractAdmin implements NavigationAdminInterface
{
    use ConfigureAdminFullTrait;

    private ?string $childListRoute = null;

    public function getChildListRoute(): ?string
    {
        return $this->childListRoute;
    }

    public function addChildNavigation(AdminInterface $admin, ?string $field = null, ?string $route = null): void
    {
        $this->addChild($admin, $field);
        $this->childListRoute = $route;
    }

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
        $this->configureFilterFieldTranslation($filter, 'title', 'NAVIGATION_ENTITY.LABEL.TITLE');
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

        $this->configureListFieldChildrenActions(list: $list, width: '300px');
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form->with($this->trans('NAVIGATION_ENTITY.SECTION.MAIN'));

        $this->configureFormFieldText($form, 'title', 'NAVIGATION_ENTITY.LABEL.TITLE');
        $this->configureFormFieldLinkEntity($form);

        $form->end();
    }
}
