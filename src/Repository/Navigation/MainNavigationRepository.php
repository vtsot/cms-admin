<?php

declare(strict_types=1);

namespace App\Repository\Navigation;

use App\Entity\Navigation\MainNavigation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<MainNavigation>
 *
 * @method MainNavigation|null find($id, $lockMode = null, $lockVersion = null)
 * @method MainNavigation|null findOneBy(array $criteria, array $orderBy = null)
 * @method MainNavigation|null findOneById(Uuid $id)
 * @method MainNavigation[]    findAll()
 * @method MainNavigation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MainNavigationRepository extends AbstractNavigationRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MainNavigation::class);
    }
}
