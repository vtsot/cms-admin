<?php

declare(strict_types=1);

namespace App\Repository\Site;

use App\Contract\Repository\FindByIdInterface;
use App\Entity\Site\SiteBanner;
use App\Repository\Traits\PositionRepositoryTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<SiteBanner>
 *
 * @method SiteBanner|null find($id, $lockMode = null, $lockVersion = null)
 * @method SiteBanner|null findOneBy(array $criteria, array $orderBy = null)
 * @method SiteBanner[]    findAll()
 * @method SiteBanner[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SiteBannerRepository extends ServiceEntityRepository implements FindByIdInterface
{
    use PositionRepositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SiteBanner::class);
    }

    public function findOneById(Uuid $id): ?SiteBanner
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
