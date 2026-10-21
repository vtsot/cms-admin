<?php

declare(strict_types=1);

namespace App\DTO\Entity\Review;

use App\Contract\Dictionary\Review\ReviewAuthorGender;
use App\Contract\Dictionary\Review\ReviewAuthorType;
use App\DTOFactory\Entity\Review\ReviewDTOFactory;
use Carbon\CarbonImmutable;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

/**
 * @see ReviewDTOFactory
 */
readonly class ReviewDTO
{
    public function __construct(
        #[Groups(['review_collection', 'review_details'])]
        #[OA\Property(type: 'string', format: 'uuid')]
        public Uuid $id,

        #[Groups(['review_collection', 'review_details'])]
        public ?string $authorName,

        #[Groups(['review_collection', 'review_details'])]
        #[OA\Property(type: 'string')]
        public ?ReviewAuthorGender $authorGender,

        #[Groups(['review_collection', 'review_details'])]
        #[OA\Property(type: 'string')]
        public ?ReviewAuthorType $authorType,

        #[Groups(['review_collection', 'review_details'])]
        public ?int $effectiveness,

        #[Groups(['review_collection', 'review_details'])]
        public ?int $easeOfUse,

        #[Groups(['review_collection', 'review_details'])]
        public ?int $satisfaction,

        #[Groups(['review_collection', 'review_details'])]
        public ?int $likeQuantity,

        #[Groups(['review_collection', 'review_details'])]
        public ?int $dislikeQuantity,

        #[Groups(['review_collection', 'review_details'])]
        public ?string $content,

        #[Groups(['review_collection', 'review_details'])]
        #[OA\Property(type: 'string', format: 'date-time')]
        public ?CarbonImmutable $createdAt,

        #[Groups(['review_collection', 'review_details'])]
        public ?ReasonReviewQuestionItemDTO $reason,

        #[Groups(['review_collection', 'review_details'])]
        public ?AgeReviewQuestionItemDTO $authorAge,

        #[Groups(['review_collection', 'review_details'])]
        public ?MedicationTimeReviewQuestionItemDTO $medicationTime,
    ) {
    }
}
