<?php

declare(strict_types=1);

namespace App\DTO\Collection\Meta;

use Symfony\Component\Serializer\Annotation\Groups;

readonly class CollectionPaginatorDTO
{
    public function __construct(
        #[Groups(['collection_meta'])]
        public int $currentPage,
        #[Groups(['collection_meta'])]
        public int $itemsPerPage,
        #[Groups(['collection_meta'])]
        public int $totalItems,
    ) {
    }
}
