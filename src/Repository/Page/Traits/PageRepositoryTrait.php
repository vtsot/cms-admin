<?php

declare(strict_types=1);

namespace App\Repository\Page\Traits;

use App\Entity\Page\AbstractPage;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Component\Uid\Uuid;

trait PageRepositoryTrait
{
    public function findOneById(Uuid $id): ?AbstractPage
    {
        return $this->find($id);
    }

    public function findOneBySiteIdAndSlug(Uuid $siteId, string $slug, ?Uuid $exceptId = null): ?AbstractPage
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.site = :siteId')->setParameter('siteId', $siteId->toBinary())
            ->andWhere('p.slug = :slug')->setParameter('slug', $slug);

        if ($exceptId !== null) {
            $qb
                ->andWhere('p.id != :exceptId')
                ->setParameter('exceptId', $exceptId->toBinary())
                ->setMaxResults(1);
        }

        try {
            return $qb
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException|NonUniqueResultException $e) {
            return null;
        }
    }

    public function findOneActiveBySiteIdAndTokenAndSlug(Uuid $siteId, string $token, string $slug): ?AbstractPage
    {
        $qb = $this->createQueryBuilder('p')
            ->join('p.site', 's', Join::WITH, 's.id = :siteId AND s.token = :token')
            ->setParameter('siteId', $siteId->toBinary())
            ->setParameter('token', $token)
            ->andWhere('s.active = :siteActive')->setParameter('siteActive', true)
            ->andWhere('p.slug = :slug')->setParameter('slug', $slug)
            ->andWhere('p.active = :pageActive')->setParameter('pageActive', true)
            ->setMaxResults(1);

        try {
            return $qb
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException) {
            return null;
        }
    }

    public function findOneActiveBySiteIdAndTokenAndPageId(Uuid $siteId, string $token, Uuid $pageId): ?AbstractPage
    {
        $qb = $this->createQueryBuilder('p')
            ->join('p.site', 's', Join::WITH, 's.id = :siteId AND s.token = :token')
            ->setParameter('siteId', $siteId->toBinary())
            ->setParameter('token', $token)
            ->andWhere('s.active = :siteActive')->setParameter('siteActive', true)
            ->andWhere('p.id = :pageId')->setParameter('pageId', $pageId->toBinary())
            ->andWhere('p.active = :pageActive')->setParameter('pageActive', true)
            ->setMaxResults(1);

        try {
            return $qb
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException) {
            return null;
        }
    }

    public function findHomepageBySiteId(Uuid $siteId): ?AbstractPage
    {
        // return $this->findOneBy(['site' => $siteId, 'homepage' => true]);
        $qb = $this->createQueryBuilder('p')
            ->where('p.site = :siteId')->setParameter('siteId', $siteId->toBinary())
            ->andWhere('p.homepage = :homepage')->setParameter('homepage', true)
            ->setMaxResults(1);

        try {
            return $qb
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException|NonUniqueResultException $e) {
            return null;
        }
    }

    public function findHomepageBySiteIdAndToken(Uuid $siteId, string $token): ?AbstractPage
    {
        $qb = $this->createQueryBuilder('p')
            ->join('p.site', 's')
            ->where('p.active = :pageActive')->setParameter('pageActive', true)
            ->andWhere('p.homepage = :homepage')->setParameter('homepage', true)
            ->andWhere('s.id = :siteId')->setParameter('siteId', $siteId->toBinary())
            ->andWhere('s.token = :token')->setParameter('token', $token)
            ->andWhere('s.active = :siteActive')->setParameter('siteActive', true)
            ->setMaxResults(1);

        try {
            return $qb
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException|NonUniqueResultException $e) {
            return null;
        }
    }

    /**
     * @return array<int, AbstractPage>
     */
    public function findAllBySiteId(Uuid $siteId): array
    {
        return $this->findBy(['site' => $siteId->toBinary()]);
    }

    /**
     * @return array<string, string>
     */
    public function getChoiceListBySiteId(Uuid $siteId): array
    {
        $items = $this->createQueryBuilder('p')
            ->select('p.id, p.title')
            ->where('p.site =:siteId')
            ->setParameter('siteId', $siteId->toBinary())
            ->orderBy('p.title', 'ASC')
            ->getQuery()
            ->getResult();

        $result = [];

        foreach ($items as $item) {
            $result[$item['title']] = (string) $item['id'];
        }

        return $result;
    }

    /**
     * @return array<int, AbstractPage>
     */
    public function findAllActiveForIndexing(Uuid $siteId, string $token): array
    {
        $qb = $this->createQueryBuilder('p')
            ->join('p.site', 's', Join::WITH, 's.id = :siteId AND s.token = :token')
            ->setParameter('siteId', $siteId->toBinary())
            ->setParameter('token', $token)
            ->andWhere('s.active = :siteActive')->setParameter('siteActive', true)
            ->andWhere('p.active = :pageActive')->setParameter('pageActive', true)
            ->andWhere('p.indexed = :indexed')->setParameter('indexed', true);

        return $qb
            ->getQuery()
            ->getResult();
    }
}
