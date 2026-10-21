<?php

declare(strict_types=1);

namespace App\Admin\Review;

use App\Admin\AbstractAdmin;
use App\Admin\Traits\ConfigureAdminFullTrait;
use App\Admin\Traits\ConfigureFormAutocompleteUsersTrait;
use App\Contract\Dictionary\User\UserRole;
use App\Entity\Site\Site;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\Route\RouteCollectionInterface;

/**
 * @method Site|null getSubject()
 */
class ReviewSiteAdmin extends AbstractAdmin
{
    use ConfigureAdminFullTrait;
    use ConfigureFormAutocompleteUsersTrait;

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues = [
            '_sort_order' => 'ASC',
            '_sort_by'    => 'domain',
        ];
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        parent::configureRoutes($collection);

        $collection->remove('create');
        $collection->remove('edit');
        $collection->remove('delete');
        $collection->remove('show');
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $this->configureFilterFieldText($filter, 'domain', 'REVIEW_ENTITY.LABEL.SITE.DOMAIN');
        $this->configureFilterFieldText($filter, 'title', 'SITE_ENTITY.LABEL.TITLE');
        $this->configureFilterFieldActive($filter);
    }

    protected function configureListFields(ListMapper $list): void
    {
        $this->configureListFieldActive(list: $list, options: ['editable' => false]);
        $this->configureListFieldText($list, 'domain', 'REVIEW_ENTITY.LABEL.SITE.DOMAIN');

        $this->configureListFieldText(
            $list,
            'reviewsQty',
            'REVIEW_ENTITY.LABEL.QTY',
            ['header_style' => 'width: 150px;'],
        );

        $this->configureListFieldChildrenActions(list: $list, width: '645px');
    }

    protected function configureQuery(ProxyQueryInterface $query): ProxyQueryInterface
    {
        /** @var ProxyQueryInterface|QueryBuilder $query */
        parent::configureQuery($query);

        $alias = current($query->getRootAliases());
        $query->leftJoin("$alias.reviews", 'reviews')
            ->addSelect('COUNT(reviews.id) AS reviewsQty')
            ->groupBy("$alias.id");

        $user = $this->getUser();

        if ($user && $user->hasRole(UserRole::SiteManager->value)) {
            // allow access only for available sites
            $alias = current($query->getRootAliases());
            $query->join("$alias.users", 'siteManager')
                ->andWhere('siteManager = :siteManager')
                ->setParameter('siteManager', $user);
        }

        return $query;
    }
}
