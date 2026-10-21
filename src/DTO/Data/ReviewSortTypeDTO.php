<?php

declare(strict_types=1);

namespace App\DTO\Data;

use App\DTOFactory\Data\ReviewSortTypeDTOFactory;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @see ReviewSortTypeDTOFactory
 */
readonly class ReviewSortTypeDTO
{
    public function __construct(
        #[Groups([
            'collection_meta',
        ])]
        #[OA\Property(type: 'string')]
        public string $key,

        #[Groups([
            'collection_meta',
        ])]
        public ?string $title,
    ) {
    }
}
