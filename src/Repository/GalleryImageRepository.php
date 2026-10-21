<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\GalleryImage;
use App\Repository\Traits\PositionRepositoryTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<GalleryImage>
 *
 * @method GalleryImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method GalleryImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method GalleryImage[]    findAll()
 * @method GalleryImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GalleryImageRepository extends ServiceEntityRepository
{
    use PositionRepositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GalleryImage::class);
    }

    /**
     * @return array<int, GalleryImage>
     */
    public function findAllActiveBySiteTokenAndSiteId(
        string $siteToken,
        Uuid $siteId,
        ?string $alias = 'q',
    ): array {
        return $this->createQueryBuilder($alias)
            ->join(
                $alias . '.site',
                's',
                Join::WITH,
                's.token = :siteToken AND s.id = :siteId'
            )
            ->andWhere($alias . '.active = :active')
            ->setParameter('siteToken', $siteToken)
            ->setParameter('siteId', $siteId)
            ->setParameter('active', true)
            ->orderBy("{$alias}.position", 'ASC')
            ->getQuery()
            ->getResult();
    }
}
