<?php

declare(strict_types=1);

namespace App\DTO\Collection;

use App\DTO\Collection\Meta\ReviewCollectionMetaDTO;
use App\DTO\Entity\Review\ReviewDTO;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Groups;

readonly class ReviewCollectionDTO
{
    public function __construct(
        /** @var ReviewDTO[] */
        #[Groups(['review_collection'])]
        #[OA\Property(
            type: 'array',
            items: new OA\Items(
                ref: new Model(
                    type: ReviewDTO::class,
                    groups: ['review_collection'],
                )),
        )]
        public array $items,

        #[Groups(['collection_meta'])]
        public ReviewCollectionMetaDTO $meta,
    ) {
    }
}
