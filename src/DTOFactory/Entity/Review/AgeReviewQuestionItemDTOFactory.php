<?php

declare(strict_types=1);

namespace App\DTOFactory\Entity\Review;

use App\DTO\Entity\Review\AgeReviewQuestionItemDTO;
use App\Entity\Review\AgeReviewQuestionItem;
use Ramsey\Uuid\Uuid;

readonly class AgeReviewQuestionItemDTOFactory
{
    public function fromEntity(
        AgeReviewQuestionItem $ageReviewQuestionItem,
    ): AgeReviewQuestionItemDTO {
        $id = $ageReviewQuestionItem->getId() ?? Uuid::fromString(Uuid::NIL);

        return new AgeReviewQuestionItemDTO(
            $id,
            $ageReviewQuestionItem->getTitle(),
        );
    }
}
