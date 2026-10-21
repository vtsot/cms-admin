<?php

declare(strict_types=1);

namespace App\DTO\Data;

use App\DTO\Entity\Review\AgeReviewQuestionItemDTO;
use App\DTO\Entity\Review\MedicationTimeReviewQuestionItemDTO;
use App\DTO\Entity\Review\ProductReviewQuestionItemDTO;
use App\DTO\Entity\Review\ReasonReviewQuestionItemDTO;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Groups;

readonly class ReviewFormDataDTO
{
    public function __construct(
        #[Groups(['review_form_data'])]
        #[OA\Property(
            type: 'array',
            items: new OA\Items(ref: new Model(type: AgeReviewQuestionItemDTO::class, groups: ['review_form_data'])),
        )]
        public array $ageItems,

        #[Groups(['review_form_data'])]
        #[OA\Property(
            type: 'array',
            items: new OA\Items(
                ref: new Model(
                    type: MedicationTimeReviewQuestionItemDTO::class,
                    groups: ['review_form_data']
                )
            ),
        )]
        public array $medicationTimeItems,

        #[Groups(['review_form_data'])]
        #[OA\Property(
            type: 'array',
            items: new OA\Items(ref: new Model(type: ReasonReviewQuestionItemDTO::class, groups: ['review_form_data'])),
        )]
        public array $reasonItems,

        #[Groups(['review_form_data'])]
        #[OA\Property(
            type: 'array',
            items: new OA\Items(ref: new Model(type: ReviewFormAuthorGenderItemDTO::class, groups: ['review_form_data'])),
        )]
        public array $authorGenderItems,

        #[Groups(['review_form_data'])]
        #[OA\Property(
            type: 'array',
            items: new OA\Items(ref: new Model(type: ReviewFormAuthorTypeItemDTO::class, groups: ['review_form_data'])),
        )]
        public array $authorTypeItems,

        #[Groups(['review_form_data'])]
        #[OA\Property(
            type: 'array',
            items: new OA\Items(ref: new Model(type: ProductReviewQuestionItemDTO::class, groups: ['review_form_data'])),
        )]
        public array $productItems,
    ) {
    }
}
