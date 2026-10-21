<?php

declare(strict_types=1);

namespace App\Repository\Navigation;

use App\Contract\Dictionary\NavigationType;
use App\Contract\Repository\FindByIdInterface;
use App\Entity\Navigation\AbstractNavigation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<AbstractNavigation>
 *
 * @method AbstractNavigation|null find($id, $lockMode = null, $lockVersion = null)
 * @method AbstractNavigation|null findOneBy(array $criteria, array $orderBy = null)
 * @method AbstractNavigation[]    findAll()
 * @method AbstractNavigation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
abstract class AbstractNavigationRepository extends ServiceEntityRepository implements FindByIdInterface
{
    public function findOneById(Uuid $id): ?AbstractNavigation
    {
        return $this->find($id);
    }

    public function createBaseQuery(
        ?string $alias = 'q',
        ?string $indexBy = null,
    ): QueryBuilder {
        return $this->createQueryBuilder($alias, $indexBy)
            ->select($alias, 'linkPage')
            ->leftJoin($alias . '.linkPage', 'linkPage')
            ->where($alias . '.active = :active')
            ->setParameter('active', true)
            ->orderBy($alias . '.position');
    }

    /**
     * @return array<int, AbstractNavigation>
     */
    public function findAllByInstance(string $entityName): array
    {
        $qb = $this->createBaseQuery();
        $qb->andWhere($qb->expr()->isInstanceOf('q', $entityName));

        return $qb->getQuery()->getResult();
    }

    /**
     * @return array<int, AbstractNavigation>
     */
    public function findAllBySiteTokenAndSiteIdAndType(string $siteToken, Uuid $siteId, NavigationType $type): array
    {
        $qb = $this->createBaseQuery('q');
        $qb->andWhere('q.type = :type')->setParameter('type', $type);
        $qb->join('q.site', 's', Join::WITH, 's.token = :siteToken AND s.id = :siteId')
            ->setParameter('siteToken', $siteToken)
            ->setParameter('siteId', $siteId);

        return $qb->getQuery()->getResult();
    }

    public function getMaximumPositionForActiveItemsBySiteIdAndParent(Uuid $siteId, ?Uuid $parentId): int
    {
        try {
            return (int) $this->createQueryBuilder('n')
                ->select('MAX(n.position)')
                ->where('n.site = :siteId')
                ->andWhere('n.active = :active')
                ->andWhere('n.parent = :parent')
                ->setParameter('siteId', $siteId)
                ->setParameter('parent', $parentId)
                ->setParameter('active', true)
                ->setMaxResults(1)
                ->getQuery()
                ->getSingleScalarResult();
        } catch (NoResultException|NonUniqueResultException $e) {
            return 0;
        }
    }
}
