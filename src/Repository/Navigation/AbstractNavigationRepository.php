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
            ->select($alias, 'linkPage', 'linkArticle')
            ->leftJoin($alias . '.linkPage', 'linkPage')
            ->leftJoin($alias . '.linkArticle', 'linkArticle')
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
    public function findAllActiveBySiteIdAndTokenAndType(Uuid $siteId, string $token, NavigationType $type): array
    {
        $qb = $this->createBaseQuery('n')
            ->join('n.site', 's', Join::WITH, 's.id = :siteId AND s.token = :token')
            ->setParameter('siteId', $siteId->toBinary())
            ->setParameter('token', $token)
            ->andWhere('n.type = :type')->setParameter('type', $type)
            ->andWhere('n.active = :navActive')->setParameter('navActive', true)
            ->andWhere('s.active = :siteActive')->setParameter('siteActive', true);

        return $qb->getQuery()
            ->getResult();
    }

    public function getMaximumPositionForActiveItemsBySiteIdAndParent(Uuid $siteId, ?Uuid $parentId): int
    {
        try {
            return (int) $this->createQueryBuilder('n')
                ->select('MAX(n.position)')
                ->where('n.site = :siteId')
                ->andWhere('n.active = :active')
                ->andWhere('n.parent = :parent')
                ->setParameter('siteId', $siteId->toBinary())
                ->setParameter('parent', $parentId->toBinary())
                ->setParameter('active', true)
                ->setMaxResults(1)
                ->getQuery()
                ->getSingleScalarResult();
        } catch (NoResultException|NonUniqueResultException $e) {
            return 0;
        }
    }
}
