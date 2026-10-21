<?php

declare(strict_types=1);

namespace App\Repository\Review;

use App\Entity\Review\AgeReviewQuestionItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<AgeReviewQuestionItem>
 *
 * @method AgeReviewQuestionItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method AgeReviewQuestionItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method AgeReviewQuestionItem[]    findAll()
 * @method AgeReviewQuestionItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method AgeReviewQuestionItem[]    findAllActiveBySiteId(Uuid $siteId)
 * @method AgeReviewQuestionItem      findOneById(Uuid $id)
 * @method AgeReviewQuestionItem|null findOneActiveByIdAndSiteId(Uuid $id, Uuid $siteId)
 */
class AgeReviewQuestionItemRepository extends AbstractReviewQuestionItemRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AgeReviewQuestionItem::class);
    }
}
