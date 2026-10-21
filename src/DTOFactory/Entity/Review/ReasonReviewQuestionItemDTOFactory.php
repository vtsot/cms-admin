<?php

declare(strict_types=1);

namespace App\DTOFactory\Entity\Review;

use App\DTO\Entity\Review\ReasonReviewQuestionItemDTO;
use App\Entity\Review\ReasonReviewQuestionItem;
use Ramsey\Uuid\Uuid;

readonly class ReasonReviewQuestionItemDTOFactory
{
    public function fromEntity(
        ReasonReviewQuestionItem $reasonReviewQuestionItem,
    ): ReasonReviewQuestionItemDTO {
        $id = $reasonReviewQuestionItem->getId() ?? Uuid::fromString(Uuid::NIL);

        return new ReasonReviewQuestionItemDTO(
            $id,
            $reasonReviewQuestionItem->getTitle(),
        );
    }

    public function fromEntityArray(
        array $entityArray,
    ): ReasonReviewQuestionItemDTO {
        return new ReasonReviewQuestionItemDTO(
            $entityArray['id'],
            $entityArray['title'],
            $entityArray['reviewsQty'],
        );
    }
}
