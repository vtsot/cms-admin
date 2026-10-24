<?php

declare(strict_types=1);

namespace App\Repository\Page\Traits;

use App\Contract\Dictionary\PageType;
use App\DTO\Collection\PageCriteriaDTO;
use App\Entity\Page\AbstractPage;
use App\Entity\Page\Article;
use App\Entity\Page\Page;
use App\Repository\Traits\OrderByRepositoryTrait;
use App\Repository\Traits\QueryConditionBuilderRepositoryTrait;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\OffsetPaginator;
use Doctrine\ORM\Tools\Pagination\Window;
use Doctrine\ORM\Tools\Pagination\WindowPage;
use Symfony\Component\Uid\Uuid;

trait PageRepositoryTrait
{
    use OrderByRepositoryTrait;
    use QueryConditionBuilderRepositoryTrait;

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

    private function createBaseQuery(Uuid $siteId, string $token, PageCriteriaDTO $criteria): QueryBuilder
    {
        [$orderBy, $orderDirection, $orderTable] = $criteria->orderBy
            ? $this->normalizeOrderBy('p', $criteria->orderBy, $criteria->orderDirection)
            : [null, null, null];

        $qb = $this
            ->createQueryBuilder('p')
            ->select('p')
            ->join('p.site', 's', Join::WITH, 's.id = :siteId AND s.token = :token')
            ->setParameter('siteId', $siteId->toBinary())
            ->setParameter('token', $token);

        // when the order by is not q (not main table)
        // join the table
        if ($orderBy && $orderTable && $orderTable !== 'p') {
            $qb->leftJoin("p.{$orderTable}", $orderTable);
        }

        if ($orderBy) {
            $qb->orderBy($orderBy, $orderDirection);
        }

        // filter by instance
        match (true) {
            $criteria->type === PageType::Page    => $qb->andWhere($qb->expr()->isInstanceOf('p', Page::class)),
            $criteria->type === PageType::Article => $qb->andWhere($qb->expr()->isInstanceOf('p', Article::class)),
            default                               => static fn () => null,
        };

        // filter by query
        if ($criteria->query !== null) {
            $qb
                // ->addSelect('a')
                ->leftJoin('p.relatedArticles', 'ra')
                ->leftJoin('ra.article', 'a')
                ->groupBy('p.id');

            $this->buildQueryCondition($criteria->query, $qb, [
                // page
                'p.title',
                'p.content',
                'p.meta_title',
                'p.meta_keywords',
                'p.meta_description',
                'p.og_title',
                'p.og_description',
                'p.sources',
                // article
                'a.title',
                'a.content',
                'a.meta_title',
                'a.meta_keywords',
                'a.meta_description',
                'a.og_title',
                'a.og_description',
                'a.sources',
                'a.description',
            ]);
        }

        // filter by slug
        if ($criteria->slug !== null) {
            $qb
                ->andWhere('p.slug = :slug')
                ->setParameter('slug', $criteria->slug)
                ->setMaxResults(1);
        }

        // filter by active
        if ($criteria->active !== null) {
            $qb
                ->andWhere('p.active = :active')
                ->setParameter('active', $criteria->active);
        }

        // filter by date range startDay
        if ($criteria->startDay !== null) {
            $qb
                ->andWhere('p.createdAt >= :startDay')
                ->setParameter('startDay', $criteria->startDay->startOfDay());
        }

        // filter by date range endDay
        if ($criteria->endDay !== null) {
            $qb
                ->andWhere('p.createdAt <= :endDay')
                ->setParameter('endDay', $criteria->endDay->endOfDay());
        }

        // filter by sitemap indexed
        if ($criteria->indexed !== null) {
            $qb
                ->andWhere('p.indexed = :indexed')
                ->setParameter('indexed', $criteria->indexed);
        }

        // filter by sitemap frequency
        if ($criteria->frequency !== null) {
            $qb
                ->andWhere('p.sitemapChangeFrequency = :frequency')
                ->setParameter('frequency', $criteria->frequency);
        }

        // filter by sitemap priority
        if ($criteria->priority !== null) {
            $qb
                ->andWhere('p.sitemapPriority = :priority')
                ->setParameter('priority', $criteria->priority);
        }

        return $qb;
    }

    public function getAllPaginatedBySiteIdAndToken(Uuid $siteId, string $token, PageCriteriaDTO $criteria): WindowPage
    {
        return new OffsetPaginator()->paginate(
            $this->createBaseQuery($siteId, $token, $criteria),
            Window::fromPageNumberAndSize($criteria->page, $criteria->perPage)
        );
    }
}
