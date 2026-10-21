<?php

declare(strict_types=1);

namespace App\Repository;

use App\Contract\Repository\FindByIdInterface;
use App\Entity\Banner;
use App\Repository\Traits\PositionRepositoryTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<Banner>
 *
 * @method Banner|null find($id, $lockMode = null, $lockVersion = null)
 * @method Banner|null findOneBy(array $criteria, array $orderBy = null)
 * @method Banner[]    findAll()
 * @method Banner[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BannerRepository extends ServiceEntityRepository implements FindByIdInterface
{
    use PositionRepositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Banner::class);
    }

    public function findOneById(Uuid $id): ?Banner
    {
        return $this->find($id);
    }

    /**
     * @return array<string, array{id: string, priority: int}>
     */
    public function findAllActivePriorityBannersByActiveSiteIdAndSiteToken(Uuid $siteId, string $siteToken): array
    {
        $qb = $this->createQueryBuilder('b')
            ->select(
                'b.id as id',
                'b.priority',
            )
            ->join('b.site', 's', Join::WITH, 's.id = :siteId AND s.token = :siteToken AND s.active = :siteActive')
            ->setParameter('siteId', $siteId)
            ->setParameter('siteToken', $siteToken)
            ->setParameter('siteActive', true)
            ->where('b.active = :active')
            ->setParameter('active', true)
            ->groupBy('b.id');

        $data = $qb
            ->getQuery()
            ->getScalarResult();

        $result = [];

        foreach ($data as $item) {
            $result[$item['id']] = [
                'id'       => $item['id'],
                'priority' => $item['priority'] ?: 1,
            ];
        }

        return $result;
    }
}
