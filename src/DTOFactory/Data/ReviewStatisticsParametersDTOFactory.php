<?php

declare(strict_types=1);

namespace App\DTOFactory\Data;

use App\DTO\Data\ReviewStatistics\ReviewStatisticsParametersDTO;
use App\DTOFactory\Entity\Review\ReviewDTOFactory;

readonly class ReviewStatisticsParametersDTOFactory
{
    public function __construct(
        private ReviewDTOFactory $reviewDTOFactory,
    ) {
    }

    public function fromArray(array $data): ReviewStatisticsParametersDTO
    {
        $reviewContest = [
            //            ReviewDTOFactory::CONTEXT_IGNORE_AUTHOR_AGE      => true,
            //            ReviewDTOFactory::CONTEXT_IGNORE_MEDICATION_TIME => true,
        ];
        $mostPopularReview  = $data['mostPopularReview'] ? $this->reviewDTOFactory->fromEntity($data['mostPopularReview'], $reviewContest) : null;
        $leastPopularReview = $data['leastPopularReview'] ? $this->reviewDTOFactory->fromEntity($data['leastPopularReview'], $reviewContest) : null;

        return new ReviewStatisticsParametersDTO(
            // effectiveness parameters
            effectiveness1Qty: (int) $data['effectiveness1Qty'],
            effectiveness2Qty: (int) $data['effectiveness2Qty'],
            effectiveness3Qty: (int) $data['effectiveness3Qty'],
            effectiveness4Qty: (int) $data['effectiveness4Qty'],
            effectiveness5Qty: (int) $data['effectiveness5Qty'],

            effectiveness1Ratio: $data['effectiveness1Ratio'],
            effectiveness2Ratio: $data['effectiveness2Ratio'],
            effectiveness3Ratio: $data['effectiveness3Ratio'],
            effectiveness4Ratio: $data['effectiveness4Ratio'],
            effectiveness5Ratio: $data['effectiveness5Ratio'],

            effectivenessAverage: $data['effectivenessAverage'],

            // easeOfUse parameters
            easeOfUse1Qty: (int) $data['easeOfUse1Qty'],
            easeOfUse2Qty: (int) $data['easeOfUse2Qty'],
            easeOfUse3Qty: (int) $data['easeOfUse3Qty'],
            easeOfUse4Qty: (int) $data['easeOfUse4Qty'],
            easeOfUse5Qty: (int) $data['easeOfUse5Qty'],

            easeOfUse1Ratio: $data['easeOfUse1Ratio'],
            easeOfUse2Ratio: $data['easeOfUse2Ratio'],
            easeOfUse3Ratio: $data['easeOfUse3Ratio'],
            easeOfUse4Ratio: $data['easeOfUse4Ratio'],
            easeOfUse5Ratio: $data['easeOfUse5Ratio'],

            easeOfUseAverage: $data['easeOfUseAverage'],

            // satisfaction parameters
            satisfaction1Qty: (int) $data['satisfaction1Qty'],
            satisfaction2Qty: (int) $data['satisfaction2Qty'],
            satisfaction3Qty: (int) $data['satisfaction3Qty'],
            satisfaction4Qty: (int) $data['satisfaction4Qty'],
            satisfaction5Qty: (int) $data['satisfaction5Qty'],

            satisfaction1Ratio: $data['satisfaction1Ratio'],
            satisfaction2Ratio: $data['satisfaction2Ratio'],
            satisfaction3Ratio: $data['satisfaction3Ratio'],
            satisfaction4Ratio: $data['satisfaction4Ratio'],
            satisfaction5Ratio: $data['satisfaction5Ratio'],

            satisfactionAverage: $data['satisfactionAverage'],

            // total parameter
            totalAverage: $data['totalAverage'],

            mostPopularReview: $mostPopularReview,
            leastPopularReview: $leastPopularReview,
        );
    }
}
