<?php

declare(strict_types=1);

namespace App\Repository\Page;

use App\Contract\Repository\FindByIdInterface;
use App\Entity\Page\PageRelatedArticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @method PageRelatedArticle|null find($id, $lockMode = null, $lockVersion = null)
 * @method PageRelatedArticle|null findOneBy(array $criteria, array $orderBy = null)
 * @method PageRelatedArticle[]    findAll()
 * @method PageRelatedArticle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageRelatedArticleRepository extends ServiceEntityRepository implements FindByIdInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageRelatedArticle::class);
    }

    public function findOneById(Uuid $id): ?PageRelatedArticle
    {
        return $this->find($id);
    }

    /**
     * @return array<int, PageRelatedArticle>
     */
    public function findAllActiveByPageId(Uuid $pageId): array
    {
        $qb = $this->createQueryBuilder('ra')
            ->join('ra.page', 'p', Join::WITH, 'p.active = :active')
            ->where('p.id = :pageId')
            ->andWhere('ra.active = :active')
            ->orderBy('ra.position', 'ASC')
            ->setParameters(new ArrayCollection([
                new Parameter('active', true),
                new Parameter('pageId', $pageId),
            ]));

        return $qb->getQuery()->getResult();
    }

    public function getMaximumPositionForActiveItemsByPageId(Uuid $pageId): int
    {
        try {
            return (int) $this->createQueryBuilder('ra')
                ->select('MAX(ra.position)')
                ->join('ra.page', 'p', Join::WITH, 'p.id = :pageId')
                ->andWhere('ra.active = :active')
                ->setParameter('pageId', $pageId)
                ->setParameter('active', true)
                ->setMaxResults(1)
                ->getQuery()
                ->getSingleScalarResult();
        } catch (NoResultException|NonUniqueResultException $e) {
            return 0;
        }
    }
}
