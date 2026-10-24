<?php

declare(strict_types=1);

namespace App\CQ\Query\Site\Page\Traits;

use function array_keys;

trait FiltersOrderByTrait
{
    /**
     * @param array<string, string> $availableOrders
     */
    public function resolveFiltersOrderBy(?string $orderBy, ?string $orderDirection, array $availableOrders = []): ?string
    {
        // resolve the key of $availableOrders
        $key = array_keys($availableOrders, $orderBy, true)[0] ?? null;

        // key was not resolve, try to get the 1st key of $availableOrders
        if ($key === null) {
            $key = array_keys($availableOrders)[0] ?? null;
        }

        return $key && $orderDirection
            ? ($key . ' ' . $orderDirection)
            : null;
    }
}
