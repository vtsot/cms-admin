<?php

declare(strict_types=1);

namespace App\Repository\Page;

use App\Contract\Repository\FindByIdInterface;
use App\Entity\Page\AbstractPage;
use App\Repository\Page\Traits\PageRepositoryTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AbstractPage|null find($id, $lockMode = null, $lockVersion = null)
 * @method AbstractPage|null findOneBy(array $criteria, array $orderBy = null)
 * @method AbstractPage[]    findAll()
 * @method AbstractPage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbstractPageRepository extends ServiceEntityRepository implements FindByIdInterface
{
    use PageRepositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AbstractPage::class);
    }
}
