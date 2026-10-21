<?php

declare(strict_types=1);

namespace App\DTO\Collection\Meta;

use App\DTO\Data\ReviewSortTypeDTO;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Groups;

readonly class ReviewCollectionMetaDTO
{
    public function __construct(
        #[Groups(['collection_meta'])]
        public CollectionPaginatorDTO $paginator,

        #[Groups(['collection_meta'])]
        public ?ReviewSortTypeDTO $appliedSortType,

        /** @var ReviewSortTypeDTO[] */
        #[Groups(['collection_meta'])]
        #[OA\Property(
            type: 'array',
            items: new OA\Items(
                ref: new Model(
                    type: ReviewSortTypeDTO::class,
                    groups: ['collection_meta'],
                )),
        )]
        public array $sortTypes,
    ) {
    }
}
