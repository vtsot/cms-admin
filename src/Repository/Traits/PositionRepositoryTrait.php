<?php

declare(strict_types=1);

namespace App\Repository\Traits;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Uid\Uuid;

trait PositionRepositoryTrait
{
    public function getMaximumPositionForActiveItemsBySiteId(Uuid $siteId): int
    {
        try {
            return (int) $this->createQueryBuilder('alias')
                ->select('MAX(alias.position)')
                ->where('alias.site = :siteId')
                ->andWhere('alias.active = :active')
                ->setParameter('siteId', $siteId)
                ->setParameter('active', true)
                ->setMaxResults(1)
                ->getQuery()
                ->getSingleScalarResult();
        } catch (NoResultException|NonUniqueResultException $e) {
            return 0;
        }
    }
}
