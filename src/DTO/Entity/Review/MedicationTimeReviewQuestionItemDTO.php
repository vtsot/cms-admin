<?php

declare(strict_types=1);

namespace App\DTO\Entity\Review;

use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

/**
 * @see MedicationTimeReviewQuestionItemDTOFactory
 */
readonly class MedicationTimeReviewQuestionItemDTO
{
    public function __construct(
        #[Groups([
            'review_form_data',
            'medication_time_review_question_item_collection',
            'medication_time_review_question_item_details',
        ])]
        #[OA\Property(type: 'string', format: 'uuid')]
        public Uuid $id,

        #[Groups([
            'review_form_data',
            'medication_time_review_question_item_collection',
            'medication_time_review_question_item_details',
        ])]
        public ?string $title,
    ) {
    }
}
