<?php

declare(strict_types=1);

namespace App\Repository\Navigation;

use App\Entity\Navigation\TopNavigation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<TopNavigation>
 *
 * @method TopNavigation|null find($id, $lockMode = null, $lockVersion = null)
 * @method TopNavigation|null findOneBy(array $criteria, array $orderBy = null)
 * @method TopNavigation|null findOneById(Uuid $id)
 * @method TopNavigation[]    findAll()
 * @method TopNavigation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TopNavigationRepository extends AbstractNavigationRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TopNavigation::class);
    }
}
