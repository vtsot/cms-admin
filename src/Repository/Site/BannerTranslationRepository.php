<?php

declare(strict_types=1);

namespace App\Repository\Site;

use App\Entity\Site\BannerTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BannerTranslation>
 *
 * @method BannerTranslation|null find($id, $lockMode = null, $lockVersion = null)
 * @method BannerTranslation|null findOneBy(array $criteria, array $orderBy = null)
 * @method BannerTranslation[]    findAll()
 * @method BannerTranslation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BannerTranslationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BannerTranslation::class);
    }
}
