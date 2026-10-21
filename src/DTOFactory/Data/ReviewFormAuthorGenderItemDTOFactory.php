<?php

declare(strict_types=1);

namespace App\DTOFactory\Data;

use App\Contract\Dictionary\Review\ReviewAuthorGender;
use App\DTO\Data\ReviewFormAuthorGenderItemDTO;

use function Symfony\Component\String\u;

readonly class ReviewFormAuthorGenderItemDTOFactory
{
    public function fromCaseCollection(): array
    {
        $items = [];

        foreach (ReviewAuthorGender::valueCases() as $case) {
            $items[] = $this->fromType($case);
        }

        return $items;
    }

    public function fromType(ReviewAuthorGender $gender): ReviewFormAuthorGenderItemDTO
    {
        return new ReviewFormAuthorGenderItemDTO(
            $gender->value,
            u($gender->name)->snake()->replace('_', ' ')->title(true)->toString(),
        );
    }
}
