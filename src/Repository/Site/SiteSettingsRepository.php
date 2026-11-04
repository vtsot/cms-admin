<?php

declare(strict_types=1);

namespace App\Repository\Site;

use App\Entity\Site\SiteSettings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<SiteSettings>
 *
 * @method SiteSettings|null find($id, $lockMode = null, $lockVersion = null)
 * @method SiteSettings|null findOneBy(array $criteria, array $orderBy = null)
 * @method SiteSettings[]    findAll()
 * @method SiteSettings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SiteSettingsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SiteSettings::class);
    }

    public function findOneBySiteIdAndToken(Uuid $siteId, string $token): ?SiteSettings
    {
        $qb = $this->createQueryBuilder('settings')
            ->join('settings.site', 's', Join::WITH, 's.id = :siteId AND s.token = :token')
            ->setParameter('siteId', $siteId->toBinary())
            ->setParameter('token', $token)
            ->setMaxResults(1);

        try {
            return $qb
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException) {
            return null;
        }
    }
}
