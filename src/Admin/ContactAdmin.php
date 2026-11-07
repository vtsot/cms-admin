<?php

declare(strict_types=1);

namespace App\Admin;

use App\Admin\Traits\ConfigureAdminFullTrait;
use App\Admin\Traits\ConfigureFilterAutocompleteSitesTrait;
use App\Contract\Dictionary\User\UserRole;
use App\Entity\Site\Contact;
use App\Entity\Site\Site;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Symfony\Component\Uid\Uuid;

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

    protected function configureQuery(ProxyQueryInterface $query): ProxyQueryInterface
    {
        /** @var ProxyQueryInterface|QueryBuilder $query */
        parent::configureQuery($query);

        if (($user = $this->getUser())
            && $user->hasRole(UserRole::SiteManager->value)
        ) {
            $expr    = $query->getEntityManager()->getExpressionBuilder();
            $siteIds = array_map(static fn (Site $site) => $site->getId(), $user->getSites()->toArray());

            // allow access only for available sites
            $alias = current($query->getRootAliases());
            $query
                ->andWhere($expr->in("$alias.site", ':siteIds'))
                ->setParameter('siteIds', array_map(static fn (Uuid $uuid) => $uuid->toBinary(), $siteIds));
        }

        return $query;
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $this->configureFilterFieldAutocompleteSites($filter, 'site');

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
