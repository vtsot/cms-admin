<?php

declare(strict_types=1);

namespace App\Repository\Review;

use App\Entity\Review\ReasonReviewQuestionItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<ReasonReviewQuestionItem>
 *
 * @method ReasonReviewQuestionItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReasonReviewQuestionItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReasonReviewQuestionItem[]    findAll()
 * @method ReasonReviewQuestionItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method ReasonReviewQuestionItem[]    findAllActiveBySiteId(Uuid $siteId)
 * @method ReasonReviewQuestionItem      findOneById(Uuid $id)
 * @method ReasonReviewQuestionItem|null findOneActiveByIdAndSiteId(Uuid $id, Uuid $siteId)
 */
class ReasonReviewQuestionItemRepository extends AbstractReviewQuestionItemRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReasonReviewQuestionItem::class);
    }

    /**
     * @return array<int, array>
     */
    public function findAllActiveWithReviewsQtyBySiteId(Uuid $siteId): array
    {
        $alias = 'q';
        $qb    = $this->createBaseQuery(
            siteId: $siteId,
            active: true,
            alias: $alias,
            orderBy: 'position',
            orderDirection: 'asc'
        );

        $qb->select([$alias . '.id', $alias . '.title', 'COUNT(r.id) AS reviewsQty'])
            ->join($alias . '.reviews', 'r', Join::WITH, 'r.active = :active')
            ->setParameter('active', true)
            ->groupBy($alias . '.id');

        return $qb->getQuery()->getResult();
    }
}
