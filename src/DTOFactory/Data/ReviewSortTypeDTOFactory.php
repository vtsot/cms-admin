<?php

declare(strict_types=1);

namespace App\DTOFactory\Data;

use App\Contract\Dictionary\Review\ReviewSortType;
use App\DTO\Data\ReviewSortTypeDTO;

use function Symfony\Component\String\u;

readonly class ReviewSortTypeDTOFactory
{
    /**
     * @return array<int, ReviewSortTypeDTO>
     */
    public function fromCaseCollection(): array
    {
        $items = [];

        foreach (ReviewSortType::valueCases() as $case) {
            $items[] = $this->fromType($case);
        }

        return $items;
    }

    public function fromType(ReviewSortType $type): ReviewSortTypeDTO
    {
        return new ReviewSortTypeDTO(
            $type->value,
            u($type->name)->snake()->replace('_', ' ')->title(true)->toString(),
        );
    }
}
