<?php

declare(strict_types=1);

namespace App\Repository\Page;

use App\Contract\Repository\SlugAwareInterface;
use App\Entity\Page\CommonPage;
use App\Repository\Traits\SlugableRepositoryTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CommonPage|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommonPage|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommonPage[]    findAll()
 * @method CommonPage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommonPageRepository extends ServiceEntityRepository // implements SlugAwareInterface
{
    //    use SlugableRepositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommonPage::class);
    }
}
