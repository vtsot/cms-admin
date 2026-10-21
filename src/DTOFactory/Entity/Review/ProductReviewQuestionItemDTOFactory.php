<?php

declare(strict_types=1);

namespace App\DTOFactory\Entity\Review;

use App\DTO\Entity\Review\ProductReviewQuestionItemDTO;
use App\Entity\Review\ProductReviewQuestionItem;
use Ramsey\Uuid\Uuid;

readonly class ProductReviewQuestionItemDTOFactory
{
    public function fromEntity(
        ProductReviewQuestionItem $productReviewQuestionItem,
    ): ProductReviewQuestionItemDTO {
        $id = $productReviewQuestionItem->getId() ?? Uuid::fromString(Uuid::NIL);

        return new ProductReviewQuestionItemDTO(
            $id,
            $productReviewQuestionItem->getTitle(),
        );
    }
}
