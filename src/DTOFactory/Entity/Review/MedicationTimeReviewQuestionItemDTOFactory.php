<?php

declare(strict_types=1);

namespace App\DTOFactory\Entity\Review;

use App\DTO\Entity\Review\MedicationTimeReviewQuestionItemDTO;
use App\Entity\Review\MedicationTimeReviewQuestionItem;
use Ramsey\Uuid\Uuid;

readonly class MedicationTimeReviewQuestionItemDTOFactory
{
    public function fromEntity(
        MedicationTimeReviewQuestionItem $medicationTimeReviewQuestionItem,
    ): MedicationTimeReviewQuestionItemDTO {
        $id = $medicationTimeReviewQuestionItem->getId() ?? Uuid::fromString(Uuid::NIL);

        return new MedicationTimeReviewQuestionItemDTO(
            $id,
            $medicationTimeReviewQuestionItem->getTitle(),
        );
    }
}
