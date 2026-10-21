<?php

declare(strict_types=1);

namespace App\DTOFactory\Data;

use App\Contract\Dictionary\Review\ReviewAuthorType;
use App\DTO\Data\ReviewFormAuthorTypeItemDTO;

use function Symfony\Component\String\u;

readonly class ReviewFormAuthorTypeItemDTOFactory
{
    public function fromCaseCollection(): array
    {
        $items = [];

        foreach (ReviewAuthorType::valueCases() as $case) {
            $items[] = $this->fromType($case);
        }

        return $items;
    }

    public function fromType(ReviewAuthorType $type): ReviewFormAuthorTypeItemDTO
    {
        return new ReviewFormAuthorTypeItemDTO(
            $type->value,
            u($type->name)->snake()->replace('_', ' ')->title(true)->toString(),
        );
    }
}
