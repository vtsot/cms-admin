<?php

declare(strict_types=1);

namespace App\Admin\User;

use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\Route\RouteCollectionInterface;

class AllUserAdmin extends AbstractUserAdmin
{
    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection->clearExcept('list');
    }

    protected function resolveUserRoles(): array
    {
        return [];
    }

    protected function configureQuery(ProxyQueryInterface $query): ProxyQueryInterface
    {
        /** @var ProxyQueryInterface|QueryBuilder $query */

        // disable softdeleteable
        if ($query->getEntityManager()->getFilters()->isEnabled('softdeleteable')) {
            $query->getEntityManager()->getFilters()->disable('softdeleteable');
        }

        return $query;
    }

    protected function configureFilterFieldRoles(
        DatagridMapper $filter,
        ?string $name = null,
        array $choices = [],
        ?string $label = null,
        array $options = [],
    ): void {
    }

    protected function configureListFields(ListMapper $list): void
    {
        $this->configureListFieldActive($list);
        $this->configureListFieldText($list, 'email', 'USER_ENTITY.LABEL.EMAIL');
        $this->configureListFieldText($list, 'firstName', 'USER_ENTITY.LABEL.FIRST_NAME');
        $this->configureListFieldText($list, 'lastName', 'USER_ENTITY.LABEL.LAST_NAME');

        $this->configureListFieldCreatedAt($list);
    }
}
