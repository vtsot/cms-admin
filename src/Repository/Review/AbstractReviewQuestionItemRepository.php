<?php

declare(strict_types=1);

namespace App\Repository\Review;

use App\Contract\Dictionary\Review\ReviewQuestionType;
use App\Entity\Review\AbstractReviewQuestionItem;
use App\Repository\Traits\PositionRepositoryTrait;
use App\Service\Util;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Uid\Uuid;

use function Symfony\Component\String\s;

/**
 * @extends ServiceEntityRepository<AbstractReviewQuestionItem>
 *
 * @method AbstractReviewQuestionItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method AbstractReviewQuestionItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method AbstractReviewQuestionItem[]    findAll()
 * @method AbstractReviewQuestionItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
abstract class AbstractReviewQuestionItemRepository extends ServiceEntityRepository
{
    use PositionRepositoryTrait;

    public function findOneById(Uuid $id): ?AbstractReviewQuestionItem
    {
        return $this->find(['id' => $id]);
    }

    public function createBaseQuery(
        ?Uuid $siteId = null,
        ?bool $active = null,
        ?string $alias = null,
        ?string $indexBy = null,
        ?string $orderBy = null,
        ?string $orderDirection = null,
        ?string $query = null,
    ): QueryBuilder {
        $alias ??= 'q';

        // create base query
        $qb = $this->createQueryBuilder($alias, $indexBy);

        // filter by $siteId
        if ($siteId !== null) {
            $qb->andWhere($alias . '.site = :siteId')
                ->setParameter('siteId', $siteId);
        }

        // filter by $active
        if ($active !== null) {
            $qb->andWhere($alias . '.active = :active')
                ->setParameter('active', $active);
        }

        // filter by query
        if ($query !== null) {
            $expr = $this->getEntityManager()->getExpressionBuilder();

            $qb->andWhere(
                $expr->orX(
                    $alias . '.title LIKE :query',
                )
            );
            $qb->setParameter('query', '%' . s($query)->toString() . '%');
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

    /**
     * @return array<int, AbstractReviewQuestionItem>
     */
    public function findAllActiveBySiteId(Uuid $siteId): array
    {
        $qb = $this->createBaseQuery(
            siteId: $siteId,
            active: true,
            alias: 'q',
            orderBy: 'position',
            orderDirection: 'asc'
        );

        return $qb->getQuery()->getResult();
    }

    /**
     * @return array<int, string>
     */
    public function getChoiceListBySiteIdAndType(Uuid $siteId, ReviewQuestionType $type): array
    {
        $qb = $this->createBaseQuery(
            siteId: $siteId,
            alias: 'q',
            orderBy: 'position',
            orderDirection: 'asc'
        )
            ->select('q.id, q.title, q.active')
            ->andWhere('q.type = :type')->setParameter('type', $type);

        $items = $qb
            ->getQuery()
            ->getResult();

        $result = [];

        foreach ($items as $item) {
            $postfix                           = $item['active'] ? '' : ' (inactive)';
            $result[$item['title'] . $postfix] = ((string) $item['id']);
        }

        return $result;
    }

    public function findOneActiveByIdAndSiteId(Uuid $id, Uuid $siteId): ?AbstractReviewQuestionItem
    {
        try {
            return $this->createBaseQuery(siteId: $siteId, active: true)
                ->andWhere('q.id = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException) {
            return null;
        }
    }
}
