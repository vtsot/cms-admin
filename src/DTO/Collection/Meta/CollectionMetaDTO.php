<?php

declare(strict_types=1);

namespace App\DTO\Collection\Meta;

use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Attribute\Groups;

final readonly class CollectionMetaDTO
{
    /** @param mixed[]|null $debug */
    public function __construct(
        #[Groups(['collection_meta'])]
        public CollectionPaginatorDTO $paginator,

        #[Groups(['collection_meta'])]
        #[OA\Property(
            ref: new Model(type: CollectionFiltersDTO::class, groups: ['collection_meta']),
        )]
        public ?CollectionFiltersDTO $filters,

        #[Groups(['collection_meta_debug'])]
        public ?array $debug = null,
    ) {
    }
}
