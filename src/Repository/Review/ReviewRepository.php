<?php

declare(strict_types=1);

namespace App\Repository\Review;

use App\Contract\Repository\FindByIdInterface;
use App\Entity\Review\Review;
use App\Service\Util;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

use function Symfony\Component\String\s;

/**
 * @method Review|null find($id, $lockMode = null, $lockVersion = null)
 * @method Review|null findOneBy(array $criteria, array $orderBy = null)
 * @method Review[]    findAll()
 * @method Review[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewRepository extends ServiceEntityRepository implements FindByIdInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    }

    public function createBaseQuery(
        ?string $siteToken = null,
        ?Uuid $siteId = null,
        ?bool $active = null,
        ?string $alias = null,
        ?string $indexBy = null,
        ?string $orderBy = null,
        ?string $orderDirection = null,
        ?string $query = null,
        ?Uuid $reasonId = null,
    ): QueryBuilder {
        $alias ??= 'q';

        // create base query
        $qb = $this->createQueryBuilder($alias, $indexBy);

        $siteWhere = [];

        if ($siteToken !== null) {
            $siteWhere[] = 's.token = :siteToken';
            $qb->setParameter('siteToken', $siteToken);
        }

        if ($siteId !== null) {
            $siteWhere[] = 's.id = :siteId';
            $qb->setParameter('siteId', $siteId);
        }

        if ($siteWhere) {
            $qb->join($alias . '.site', 's', Join::WITH, implode(' AND ', $siteWhere));
        }

        // filter by $active
        if ($active !== null) {
            $qb->andWhere($alias . '.active = :active')
                ->setParameter('active', $active);
        }

        // filter by query
        if ($query !== null) {
            $expr              = $this->getEntityManager()->getExpressionBuilder();
            $queryOrConditions = [];

            //            $qb->andWhere(
            //                $expr->orX(
            //                    $alias . '.authorName LIKE :query',
            //                    $alias . '.description LIKE :query',
            //                )
            //            );
            //            $qb->setParameter('query', '%' . s($query)->toString() . '%');

            // split up query to words
            foreach (s($query)->split(' ') as $i => $item) {
                $queryOrConditions[] = $expr->orX(
                    $alias . '.authorName LIKE :query' . $i,
                    $alias . '.description LIKE :query' . $i,
                );
                $qb->setParameter('query' . $i, '%' . $item->toString() . '%');
            }

            $qb->andWhere($expr->orX(...$queryOrConditions));
        }

        // filter by $reasonId
        if ($reasonId) {
            $qb->andWhere($alias . '.reason = :reasonId')
                ->setParameter('reasonId', $reasonId);
        }

        // resolve ordering
        [$orderBy, $orderDirection] = $orderBy !== null
            ? Util::normalizeOrderBy($alias, $orderBy, $orderDirection)
            : [null, null];

        // apply ordering
        if ($orderBy !== null && $orderDirection !== null) {
            $qb->orderBy($orderBy, $orderDirection);
        }

        return $qb;
    }

    public function findOneById(Uuid $id): ?Review
    {
        return $this->find(['id' => $id]);
    }

    public function getStatisticsForActiveReviewBySiteTokenAndSiteId(
        ?string $siteToken,
        ?Uuid $siteId,
        ?string $query,
        ?Uuid $reasonId,
    ): ?array {
        $qb = $this->createBaseQuery(
            siteToken: $siteToken,
            siteId: $siteId,
            active: true,
            alias: 'r',
            query: $query,
            reasonId: $reasonId,
        );

        $selectsData = [
            'COUNT(r.id) AS totalQty',
        ];

        $indexes = range(1, 5);

        foreach (Review::EVALUATIVE_INDICATORS as $property) {
            foreach ($indexes as $ind) {
                $selectsData[] = "SUM(CASE WHEN r.{$property} = {$ind} THEN 1 ELSE 0 END) AS {$property}{$ind}Qty";
            }
        }

        $qb->select($selectsData);

        try {
            return $qb
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException) {
            return null;
        }
    }

    public function getMostOrLeastActiveReviewBySiteTokenAndSiteId(
        ?string $siteToken,
        ?Uuid $siteId,
        ?string $query,
        ?Uuid $reasonId,
        string $order,
        string $alias,
    ): ?Review {
        try {
            $qb = $this->createBaseQuery(
                siteToken: $siteToken,
                siteId: $siteId,
                active: true,
                alias: $alias,
                query: $query,
                reasonId: $reasonId,
            )
                ->orderBy("CAST({$alias}.likeQuantity AS SIGNED) - CAST({$alias}.dislikeQuantity AS SIGNED)", $order);

            if ($order === 'desc') {
                // it's a request to get the most popular review => exclude reviews that don't have any likes
                $qb->andWhere("{$alias}.likeQuantity > 0");
            } else {
                // this is a request to get the least popular review => exclude reviews that don't have any dislikes
                $qb->andWhere("{$alias}.dislikeQuantity > 0");
            }

            return $qb
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException) {
            return null;
        }
    }
}
