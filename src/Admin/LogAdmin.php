<?php

declare(strict_types=1);

namespace App\Admin;

use App\Admin\Traits\ConfigureAdminFullTrait;
use App\Admin\Traits\ConfigureFilterAutocompleteSitesTrait;
use App\Contract\Dictionary\User\UserRole;
use App\Entity\Log;
use App\Entity\Site\Site;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Symfony\Component\Uid\Uuid;

use function array_map;
use function current;

/**
 * @method Log getSubject()
 */
class LogAdmin extends AbstractAdmin
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

        $this->configureFilterFieldText($filter, 'message', 'LOG_ENTITY.LABEL.MESSAGE');
        $this->configureFilterFieldText($filter, 'method', 'LOG_ENTITY.LABEL.METHOD');
        $this->configureFilterFieldText($filter, 'url', 'LOG_ENTITY.LABEL.URL');
        $this->configureFilterFieldText($filter, 'request', 'LOG_ENTITY.LABEL.REQUEST');
        $this->configureFilterFieldText($filter, 'response', 'LOG_ENTITY.LABEL.RESPONSE');
        $this->configureFilterFieldText($filter, 'entryId', 'LOG_ENTITY.LABEL.ENTRY_ID');
        $this->configureFilterFieldText($filter, 'content', 'LOG_ENTITY.LABEL.CONTENT');
        $this->configureFilterFieldText($filter, 'payload', 'LOG_ENTITY.LABEL.PAYLOAD');

        $this->configureFilterFieldCreatedAtDateRange($filter);
        $this->configureFilterFieldUpdatedAtDateRange($filter);
    }

    protected function configureListFields(ListMapper $list): void
    {
        $this->configureListFieldText($list, 'site.domain', 'LOG_ENTITY.LABEL.SITE');
        $this->configureListFieldText(
            $list,
            'content-virtual',
            'LOG_ENTITY.LABEL.CONTENT',
            [
                'virtual_field' => true,
                'template'      => 'admin/CRUD/log/list__content.html.twig',
            ]
        );

        $this->configureListFieldChangedAt($list);
        $this->configureListFieldActions($list, ['delete' => []]);
    }
}
