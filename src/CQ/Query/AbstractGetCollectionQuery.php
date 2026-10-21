<?php

declare(strict_types=1);

namespace App\CQ\Query;

abstract readonly class AbstractGetCollectionQuery
{
    public function __construct(
        public ?string $query = null,
        public ?int $page = 1,
        public ?int $perPage = 10,
        public ?string $orderBy = null,
        public ?string $orderDirection = null,
    ) {
    }
}
