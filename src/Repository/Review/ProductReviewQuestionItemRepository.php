<?php

declare(strict_types=1);

namespace App\Repository\Review;

use App\Entity\Review\ProductReviewQuestionItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<ProductReviewQuestionItem>
 *
 * @method ProductReviewQuestionItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductReviewQuestionItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductReviewQuestionItem[]    findAll()
 * @method ProductReviewQuestionItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method ProductReviewQuestionItem[]    findAllActiveBySiteId(Uuid $siteId)
 * @method ProductReviewQuestionItem      findOneById(Uuid $id)
 * @method ProductReviewQuestionItem|null findOneActiveByIdAndSiteId(Uuid $id, Uuid $siteId)
 */
class ProductReviewQuestionItemRepository extends AbstractReviewQuestionItemRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductReviewQuestionItem::class);
    }
}
