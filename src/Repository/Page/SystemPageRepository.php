<?php

declare(strict_types=1);

namespace App\Repository\Page;

use App\Contract\Repository\SlugAwareInterface;
use App\Entity\Page\SystemPage;
use App\Repository\Traits\SlugableRepositoryTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SystemPage|null find($id, $lockMode = null, $lockVersion = null)
 * @method SystemPage|null findOneBy(array $criteria, array $orderBy = null)
 * @method SystemPage[]    findAll()
 * @method SystemPage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SystemPageRepository extends ServiceEntityRepository // implements SlugAwareInterface
{
    //    use SlugableRepositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SystemPage::class);
    }
}
