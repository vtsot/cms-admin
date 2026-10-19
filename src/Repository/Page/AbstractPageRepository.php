<?php

declare(strict_types=1);

namespace App\Repository\Page;

use App\Contract\Repository\FindByIdInterface;
use App\Contract\Repository\SlugAwareInterface;
use App\Entity\Page\AbstractPage;
// use App\Repository\Traits\SlugableRepositoryTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

// use Ramsey\Uuid\UuidInterface;

/**
 * @method AbstractPage|null find($id, $lockMode = null, $lockVersion = null)
 * @method AbstractPage|null findOneBy(array $criteria, array $orderBy = null)
 * @method AbstractPage[]    findAll()
 * @method AbstractPage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbstractPageRepository extends ServiceEntityRepository // implements SlugAwareInterface, FindByIdInterface
{
    //    use SlugableRepositoryTrait;

        public function __construct(ManagerRegistry $registry)
        {
            parent::__construct($registry, AbstractPage::class);
        }

    //    public function findOneById(UuidInterface $id): ?AbstractPage
    //    {
    //        return $this->find($id);
    //    }

    public function findAllForIndexing(): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.active = :active')->setParameter('active', true)
            ->andWhere('p.indexed = :indexed')->setParameter('indexed', true)
            ->getQuery()
            ->getResult();
    }
}
