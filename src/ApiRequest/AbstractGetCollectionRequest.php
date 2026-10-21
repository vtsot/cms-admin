<?php

declare(strict_types=1);

namespace App\ApiRequest;

use App\Contract\ApiRequest\ApiRequestInterface;

use function explode;
use function in_array;
use function preg_replace;
use function strtolower;
use function trim;

abstract class AbstractGetCollectionRequest implements ApiRequestInterface
{
    public const DEFAULT_ORDER_DIRECTION = 'asc';

    public readonly ?int $page;
    public readonly ?int $perPage;
    public readonly ?string $orderBy;

    public readonly ?string $orderDirection;

    public function __construct(
        public readonly ?string $query,
        ?string $sort,
        ?int $page = null,
        ?int $perPage = null,
    ) {
        $this->page    = $page ?? 1;
        $this->perPage = $perPage ?? 10;

        $orderBy        = null;
        $orderDirection = null;

        if ($sort !== null) {
            $result = explode(' ', trim(preg_replace('/\s+/', ' ', $sort)));

            $orderBy        = $result[0] ?? null;
            $orderDirection = $result[1] ?? null;
        }

        $this->orderBy = $orderBy;

        if (!$orderDirection || !in_array(strtolower($orderDirection), ['asc', 'desc'], true)) {
            $orderDirection = static::DEFAULT_ORDER_DIRECTION;
        }

        $this->orderDirection = $orderDirection ? strtolower($orderDirection) : null;
    }
}
