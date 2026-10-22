<?php

declare(strict_types=1);

namespace App\Repository\Page\Traits;

use App\Entity\Page\AbstractPage;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\Query\Parameter;
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
            ->where('p.site = :siteId')
            ->andWhere('p.slug = :slug')
            ->setParameters(
                new ArrayCollection([
                    new Parameter('siteId', $siteId->toBinary()),
                    new Parameter('slug', $slug),
                ]),
            );

        if ($exceptId !== null) {
            $qb->andWhere('p.id != :exceptId')
                ->setParameter('exceptId', $exceptId->toBinary());
        }

        try {
            return $qb->setMaxResults(1)
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException|NonUniqueResultException $e) {
            return null;
        }
    }

    public function findOneActiveBySiteTokenAndSiteIdAndSlug(string $siteToken, Uuid $siteId, string $slug): ?AbstractPage
    {
        try {
            return $this->createQueryBuilder('p')
                ->join('p.site', 's', Join::WITH, 's.token = :siteToken AND s.id = :siteId')
                ->andWhere('p.slug = :slug')
                ->andWhere('p.active = :isActive')
                ->setParameters(
                    new ArrayCollection([
                        new Parameter('siteToken', $siteToken),
                        new Parameter('siteId', $siteId->toBinary()),
                        new Parameter('slug', $slug),
                        new Parameter('isActive', true),
                    ])
                )
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException) {
            return null;
        }
    }

    public function findHomepageBySiteId(Uuid $siteId): ?AbstractPage
    {
        return $this->findOneBy(['site' => $siteId, 'homepage' => true]);
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
    public function findAllActiveForIndexing(string $siteToken, Uuid $siteId): array
    {
        return $this->createQueryBuilder('p')
            ->join('p.site', 's', Join::WITH, 's.token = :siteToken AND s.id = :siteId')
            ->where('p.active = :active')->setParameter('active', true)
            ->andWhere('p.indexed = :indexed')->setParameter('indexed', true)
            ->setParameters(
                new ArrayCollection([
                    new Parameter('siteToken', $siteToken),
                    new Parameter('siteId', $siteId->toBinary()),
                    new Parameter('active', true),
                    new Parameter('indexed', true),
                ])
            )
            ->getQuery()
            ->getResult();
    }
}
