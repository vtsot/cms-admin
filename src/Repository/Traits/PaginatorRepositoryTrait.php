<?php

declare(strict_types=1);

namespace App\Repository\Traits;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\OffsetPaginator;
use Doctrine\ORM\Tools\Pagination\Window;

use function array_values;

trait PaginatorRepositoryTrait
{
    private const int MAX_PER_PAGE = 1000;

    protected function paginate(
        QueryBuilder $qb,
        ?int $page,
        ?int $perPage,
        bool $fetchJoinCollection = true,
    ): PaginatedResult {
        $page    = $page > 0 ? $page : 1;
        $perPage = $perPage > 0 && $perPage <= self::MAX_PER_PAGE ? $perPage : self::MAX_PER_PAGE;

        $query = $qb
            ->setMaxResults($perPage)
            ->setFirstResult(($page - 1) * $perPage)
            ->getQuery();

        $window     = Window::fromPageNumberAndSize($page, $perPage);
        $windowPage = new OffsetPaginator($fetchJoinCollection)->paginate($query, $window);

        return new PaginatedResult(array_values($windowPage->getItems()), $windowPage->getTotalCount());
    }
}
