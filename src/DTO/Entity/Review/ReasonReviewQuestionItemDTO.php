<?php

declare(strict_types=1);

namespace App\DTO\Entity\Review;

use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

/**
 * @see ReasonReviewQuestionItemDTOFactory
 */
readonly class ReasonReviewQuestionItemDTO
{
    public function __construct(
        #[Groups([
            'review_form_data',
            'reason_review_question_item_collection',
            'reason_review_question_item_details',
        ])]
        #[OA\Property(type: 'string', format: 'uuid')]
        public Uuid $id,

        #[Groups([
            'review_form_data',
            'reason_review_question_item_collection',
            'reason_review_question_item_details',
        ])]
        public ?string $title,

        #[Groups([
            'review_form_data',
            'reason_review_question_item_collection',
            'reason_review_question_item_details',
        ])]
        public ?int $reviewsQuantity = null,
    ) {
    }
}
