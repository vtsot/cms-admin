<?php

declare(strict_types=1);

namespace App\Repository\Faq;

use App\Contract\Repository\FindByIdInterface;
use App\Entity\Faq\FaqGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<FaqGroup>
 *
 * @method FaqGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method FaqGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method FaqGroup[]    findAll()
 * @method FaqGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FaqGroupRepository extends ServiceEntityRepository implements FindByIdInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FaqGroup::class);
    }

    public function findOneById(Uuid $id): ?FaqGroup
    {
        return $this->find($id);
    }

    public function findOneBySiteTokenAndSiteIdAndId(
        string $siteToken,
        Uuid $siteId,
        Uuid $id,
        bool $activeOnly = true,
    ): ?FaqGroup {
        try {
            return $this->createQueryBuilder('fg')
                ->select('fg')
                ->join('fg.site', 's', Join::WITH, 's.token = :siteToken AND s.id = :siteId')
                ->andWhere('fg.id = :id')
                ->andWhere('fg.active = :active')
                ->setParameter('id', $id)
                ->setParameter('active', $activeOnly)
                ->setParameter('siteToken', $siteToken)
                ->setParameter('siteId', $siteId)
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException) {
            return null;
        }
    }

    public function findAllBySiteTokenAndSiteId(
        ?string $siteToken = null,
        ?Uuid $siteId = null,
        bool $activeOnly = true,
    ): array {
        return $this->createQueryBuilder('fg')
            ->select('fg')
            ->join('fg.site', 's', Join::WITH, 's.token = :siteToken AND s.id = :siteId')
            ->andWhere('fg.active = :active')
            ->setParameter('active', $activeOnly)
            ->setParameter('siteToken', $siteToken)
            ->setParameter('siteId', $siteId)
            ->getQuery()
            ->getResult();
    }
}
