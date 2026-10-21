<?php

declare(strict_types=1);

namespace App\DTO\Collection\Meta;

use Symfony\Component\Serializer\Annotation\Groups;

readonly class CollectionMetaDTO
{
    public function __construct(
        #[Groups(['collection_meta'])]
        public CollectionPaginatorDTO $paginator,
    ) {
    }
}
