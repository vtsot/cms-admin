<?php

declare(strict_types=1);

namespace App\DTO\Collection\Meta;

use App\DTO\Collection\CollectionFiltersDTO;
use Symfony\Component\Serializer\Annotation\Groups;

readonly class CollectionMetaFilterDTO
{
    public function __construct(
        #[Groups(['collection_meta'])]
        public CollectionPaginatorDTO $paginator,
        #[Groups(['collection_meta'])]
        public ?CollectionFiltersDTO $filters = null,
    ) {
    }
}
