<?php

declare(strict_types=1);

namespace App\Repository\Site;

use App\Contract\Repository\FindByIdInterface;
use App\Entity\Site\Site;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<Site>
 *
 * @method Site|null find($id, $lockMode = null, $lockVersion = null)
 * @method Site|null findOneBy(array $criteria, array $orderBy = null)
 * @method Site[]    findAll()
 * @method Site[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SiteRepository extends ServiceEntityRepository implements FindByIdInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Site::class);
    }

    public function findOneById(Uuid $id): ?Site
    {
        return $this->find(['id' => $id]);
    }

    public function findOneActiveByTokenAndId(string $token, Uuid $id): ?Site
    {
        return $this->findOneBy(['token' => $token, 'id' => $id, 'active' => true]);
    }

    public function findOneByToken(string $token): ?Site
    {
        return $this->findOneBy(['token' => $token]);
    }

    public function findOneByIdAndUser(Uuid $id, Uuid $userId): ?Site
    {
        try {
            return $this->createQueryBuilder('s')
                ->join('s.users', 'u', Join::WITH, 'u.id = :userId')->setParameter('userId', $userId)
                ->where('s.id = :siteId')->setParameter('siteId', $id->toBinary())
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException) {
            return null;
        }
    }

    private function createBaseExpireAtRangeQuery(
        CarbonInterface $startAt,
        CarbonInterface $endAt,
    ): QueryBuilder {
        $expr = $this->getEntityManager()->getExpressionBuilder();

        return $this->createQueryBuilder('s')
            ->where($expr->isNotNull('s.expireAt'))
            ->andWhere('s.expireAt BETWEEN :startAt AND :endAt')
            ->setParameter('startAt', $startAt)
            ->setParameter('endAt', $endAt);
    }

    /**
     * @return array<int, string>
     */
    public function findAllActiveSiteIdsWhereExpireAt4WeeksBefore(): array
    {
        $startAt = Carbon::today()->addWeeks(4)->startOfDay();
        $endAt   = Carbon::today()->addWeeks(4)->addDay()->startOfDay();
        $qb      = $this->createBaseExpireAtRangeQuery($startAt, $endAt);
        $alias   = $qb->getRootAliases()[0] ?? 's';

        $qb->select("{$alias}.id")
            ->andWhere("{$alias}.active = :active")
            ->setParameter('active', true);

        return $qb->getQuery()->getSingleColumnResult();
    }

    /**
     * @return array<int, string>
     */
    public function findAllActiveSiteIdsWhereExpireAt2WeeksBefore(): array
    {
        $startAt = Carbon::today()->addWeeks(2)->startOfDay();
        $endAt   = Carbon::today()->addWeeks(2)->addDay()->startOfDay();
        $qb      = $this->createBaseExpireAtRangeQuery($startAt, $endAt);
        $alias   = $qb->getRootAliases()[0] ?? 's';

        $qb->select("{$alias}.id")
            ->andWhere("{$alias}.active = :active")
            ->setParameter('active', true);

        return $qb->getQuery()->getSingleColumnResult();
    }

    /**
     * @return array<int, string>
     */
    public function findAllActiveSiteIdsWhereExpireAt1DayBefore(): array
    {
        $startAt = Carbon::tomorrow()->startOfDay();
        $endAt   = Carbon::tomorrow()->addDay()->startOfDay();
        $qb      = $this->createBaseExpireAtRangeQuery($startAt, $endAt);
        $alias   = $qb->getRootAliases()[0] ?? 's';

        $qb->select("{$alias}.id")
            ->andWhere("{$alias}.active = :active")
            ->setParameter('active', true);

        return $qb->getQuery()->getSingleColumnResult();
    }
}
