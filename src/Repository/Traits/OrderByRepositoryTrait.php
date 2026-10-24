<?php

declare(strict_types=1);

namespace App\Repository\Traits;

use function explode;
use function sprintf;
use function str_contains;
use function Symfony\Component\String\s;

trait OrderByRepositoryTrait
{
    /**
     * 0: order by q.name
     * 1: desc|asc
     * 2: table name.
     *
     * @return array{0: string, 1: string|null, 2: string}
     */
    protected function normalizeOrderBy(string $mainTable, string $orderBy, ?string $orderDirection): array
    {
        if (str_contains($orderBy, '.')) {
            [$table, $field] = explode('.', $orderBy);
        } else {
            $table = $mainTable;
            $field = $orderBy;
        }

        return [
            sprintf('%s.%s', $table, s($field)->camel()->toString()),
            $orderDirection,
            $table,
        ];
    }
}
