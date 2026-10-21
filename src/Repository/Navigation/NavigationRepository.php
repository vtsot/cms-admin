<?php

declare(strict_types=1);

namespace App\Repository\Navigation;

use App\Entity\Navigation\AbstractNavigation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AbstractNavigation>
 *
 * @method AbstractNavigation|null find($id, $lockMode = null, $lockVersion = null)
 * @method AbstractNavigation|null findOneBy(array $criteria, array $orderBy = null)
 * @method AbstractNavigation[]    findAll()
 * @method AbstractNavigation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NavigationRepository extends AbstractNavigationRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AbstractNavigation::class);
    }
}
