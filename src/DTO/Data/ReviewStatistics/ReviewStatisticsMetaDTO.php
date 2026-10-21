<?php

declare(strict_types=1);

namespace App\DTO\Data\ReviewStatistics;

use App\DTO\Entity\Review\ReasonReviewQuestionItemDTO;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Groups;

readonly class ReviewStatisticsMetaDTO
{
    public function __construct(
        #[Groups(['collection_meta'])]
        public ?ReasonReviewQuestionItemDTO $appliedReason,

        #[Groups(['collection_meta'])]
        #[OA\Property(
            type: 'array',
            items: new OA\Items(
                ref: new Model(
                    type: ReasonReviewQuestionItemDTO::class,
                    groups: ['collection_meta']
                )
            ))]
        public array $reasons,
    ) {
    }
}
