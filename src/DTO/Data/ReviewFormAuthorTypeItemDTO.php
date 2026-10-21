<?php

declare(strict_types=1);

namespace App\DTO\Data;

use App\DTOFactory\Data\ReviewFormAuthorTypeItemDTOFactory;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @see ReviewFormAuthorTypeItemDTOFactory
 */
readonly class ReviewFormAuthorTypeItemDTO
{
    public function __construct(
        #[Groups([
            'review_form_data',
        ])]
        #[OA\Property(type: 'string')]
        public string $key,

        #[Groups([
            'review_form_data',
        ])]
        public ?string $title,
    ) {
    }
}
