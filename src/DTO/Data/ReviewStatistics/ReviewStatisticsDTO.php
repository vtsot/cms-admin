<?php

declare(strict_types=1);

namespace App\DTO\Data\ReviewStatistics;

use Symfony\Component\Serializer\Annotation\Groups;

readonly class ReviewStatisticsDTO
{
    public function __construct(
        #[Groups(['review_statistics'])]
        public ReviewStatisticsParametersDTO $parameters,
        #[Groups(['collection_meta'])]
        public ReviewStatisticsMetaDTO $meta,
    ) {
    }
}
