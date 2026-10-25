<?php

declare(strict_types=1);

namespace App\Repository\Navigation;

use App\Entity\Navigation\NavigationTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NavigationTranslation>
 *
 * @method NavigationTranslation|null find($id, $lockMode = null, $lockVersion = null)
 * @method NavigationTranslation|null findOneBy(array $criteria, array $orderBy = null)
 * @method NavigationTranslation[]    findAll()
 * @method NavigationTranslation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NavigationTranslationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NavigationTranslation::class);
    }
}
