<?php

declare(strict_types=1);

namespace App\DTO\Collection\Meta;

use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\SerializedName;

final readonly class CollectionPaginatorDTO
{
    public function __construct(
        #[Groups(['collection_meta'])]
        public int $page,

        #[Groups(['collection_meta'])]
        #[SerializedName('per_page')]
        public int $perPage,

        #[Groups(['collection_meta'])]
        public int $total,
    ) {
    }
}
