<?php

declare(strict_types=1);

namespace App\DTO\Data\ReviewStatistics;

use App\DTO\Entity\Review\ReviewDTO;
use App\DTOFactory\Data\ReviewStatisticsParametersDTOFactory;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @see ReviewStatisticsParametersDTOFactory
 */
readonly class ReviewStatisticsParametersDTO
{
    public function __construct(
        #[Groups(['review_statistics'])]
        public int $effectiveness1Qty,

        #[Groups(['review_statistics'])]
        public int $effectiveness2Qty,

        #[Groups(['review_statistics'])]
        public int $effectiveness3Qty,

        #[Groups(['review_statistics'])]
        public int $effectiveness4Qty,

        #[Groups(['review_statistics'])]
        public int $effectiveness5Qty,

        #[Groups(['review_statistics'])]
        public float $effectiveness1Ratio,

        #[Groups(['review_statistics'])]
        public float $effectiveness2Ratio,

        #[Groups(['review_statistics'])]
        public float $effectiveness3Ratio,

        #[Groups(['review_statistics'])]
        public float $effectiveness4Ratio,

        #[Groups(['review_statistics'])]
        public float $effectiveness5Ratio,

        #[Groups(['review_statistics'])]
        public float $effectivenessAverage,

        #[Groups(['review_statistics'])]
        public int $easeOfUse1Qty,

        #[Groups(['review_statistics'])]
        public int $easeOfUse2Qty,

        #[Groups(['review_statistics'])]
        public int $easeOfUse3Qty,

        #[Groups(['review_statistics'])]
        public int $easeOfUse4Qty,

        #[Groups(['review_statistics'])]
        public int $easeOfUse5Qty,

        #[Groups(['review_statistics'])]
        public float $easeOfUse1Ratio,

        #[Groups(['review_statistics'])]
        public float $easeOfUse2Ratio,

        #[Groups(['review_statistics'])]
        public float $easeOfUse3Ratio,

        #[Groups(['review_statistics'])]
        public float $easeOfUse4Ratio,

        #[Groups(['review_statistics'])]
        public float $easeOfUse5Ratio,

        #[Groups(['review_statistics'])]
        public float $easeOfUseAverage,

        #[Groups(['review_statistics'])]
        public int $satisfaction1Qty,

        #[Groups(['review_statistics'])]
        public int $satisfaction2Qty,

        #[Groups(['review_statistics'])]
        public int $satisfaction3Qty,

        #[Groups(['review_statistics'])]
        public int $satisfaction4Qty,

        #[Groups(['review_statistics'])]
        public int $satisfaction5Qty,

        #[Groups(['review_statistics'])]
        public float $satisfaction1Ratio,

        #[Groups(['review_statistics'])]
        public float $satisfaction2Ratio,

        #[Groups(['review_statistics'])]
        public float $satisfaction3Ratio,

        #[Groups(['review_statistics'])]
        public float $satisfaction4Ratio,

        #[Groups(['review_statistics'])]
        public float $satisfaction5Ratio,

        #[Groups(['review_statistics'])]
        public float $satisfactionAverage,

        #[Groups(['review_statistics'])]
        public float $totalAverage,

        #[Groups(['review_statistics'])]
        #[OA\Property(type: 'array', items: new OA\Items(
            ref: new Model(type: ReviewDTO::class, groups: ['review_collection', 'review_details']),
        ))]
        /**
         * @var ReviewDTO[]
         */
        public ?ReviewDTO $mostPopularReview,

        #[Groups(['review_statistics'])]
        #[OA\Property(type: 'array', items: new OA\Items(
            ref: new Model(type: ReviewDTO::class, groups: ['review_collection', 'review_details']),
        ))]
        /**
         * @var ReviewDTO[]
         */
        public ?ReviewDTO $leastPopularReview,
    ) {
    }
}
