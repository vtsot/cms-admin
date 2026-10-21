<?php

declare(strict_types=1);

namespace App\DTO\Collection;

use App\DTO\Collection\Meta\CollectionMetaDTO;
use Symfony\Component\Serializer\Annotation\Groups;

abstract readonly class AbstractCollectionDTO
{
    public function __construct(
        public array $items = [],
        #[Groups(['collection_meta'])]
        public ?CollectionMetaDTO $meta = null,
    ) {
    }
}
