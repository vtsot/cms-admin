<?php

declare(strict_types=1);

namespace App\DTO\Collection;

use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Attribute\Groups;

readonly class CollectionFiltersDTO
{
    public function __construct(
        #[Groups(['collection_meta'])]
        public ?string $query,
        #[Groups(['collection_meta'])]
        #[OA\Property(
            property: 'available_filters',
            type: 'array',
            items: new OA\Items(type: 'string'),
        )]
        public mixed $availableFilters,
        #[Groups('collection_meta')]
        public ?string $order,
        #[Groups('collection_meta')]
        #[OA\Property(
            property: 'available_orders',
            type: 'array',
            items: new OA\Items(type: 'string'),
        )]
        public ?array $availableOrders,
        #[Groups(['collection_meta'])]
        #[OA\Property(
            property: 'applied_filters',
            type: 'array',
            items: new OA\Items(type: 'string'),
        )]
        public mixed $appliedFilters = null,
    ) {
    }
}
