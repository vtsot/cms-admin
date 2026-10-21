<?php

declare(strict_types=1);

namespace App\DTOFactory\Entity\Review;

use App\DTO\Entity\Review\ReviewDTO;
use App\Entity\Review\Review;
use Ramsey\Uuid\Uuid;

readonly class ReviewDTOFactory
{
    public const CONTEXT_IGNORE_AUTHOR_AGE      = 'ignore-author-age';
    public const CONTEXT_IGNORE_MEDICATION_TIME = 'ignore-medication-time';

    public function __construct(
        private ReasonReviewQuestionItemDTOFactory $reasonReviewQuestionItemDTOFactory,
        private AgeReviewQuestionItemDTOFactory $ageReviewQuestionItemDTOFactory,
        private MedicationTimeReviewQuestionItemDTOFactory $medicationTimeReviewQuestionItemDTOFactory,
    ) {
    }

    public function fromEntity(Review $review, array $context = []): ReviewDTO
    {
        $id = $review->getId() ?? Uuid::fromString(Uuid::NIL);

        $reason = $review->getReason()
            ? $this->reasonReviewQuestionItemDTOFactory->fromEntity($review->getReason())
            : null;

        $authorAge = $review->getAuthorAge() && empty($context[self::CONTEXT_IGNORE_AUTHOR_AGE])
            ? $this->ageReviewQuestionItemDTOFactory->fromEntity($review->getAuthorAge())
            : null;

        $medicationTime = $review->getMedicationTime() && empty($context[self::CONTEXT_IGNORE_MEDICATION_TIME])
            ? $this->medicationTimeReviewQuestionItemDTOFactory->fromEntity($review->getMedicationTime())
            : null;

        return new ReviewDTO(
            $id,
            $review->getAuthorName(),
            $review->getAuthorGender(),
            $review->getAuthorType(),
            $review->getEffectiveness(),
            $review->getEaseOfUse(),
            $review->getSatisfaction(),
            $review->getLikeQuantity(),
            $review->getDislikeQuantity(),
            $review->getContent(),
            $review->getCreatedAt(),
            $reason,
            $authorAge,
            $medicationTime,
        );
    }
}
