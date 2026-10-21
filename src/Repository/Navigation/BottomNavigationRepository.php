<?php

declare(strict_types=1);

namespace App\Repository\Navigation;

use App\Entity\Navigation\BottomNavigation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<BottomNavigation>
 *
 * @method BottomNavigation|null find($id, $lockMode = null, $lockVersion = null)
 * @method BottomNavigation|null findOneBy(array $criteria, array $orderBy = null)
 * @method BottomNavigation|null findOneById(Uuid $id)
 * @method BottomNavigation[]    findAll()
 * @method BottomNavigation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BottomNavigationRepository extends AbstractNavigationRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BottomNavigation::class);
    }
}
