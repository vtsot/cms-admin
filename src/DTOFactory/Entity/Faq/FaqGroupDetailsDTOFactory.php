<?php

declare(strict_types=1);

namespace App\DTOFactory\Entity\Faq;

use App\DTO\Entity\Faq\FaqGroupDetailsDTO;
use App\Entity\Faq\FaqGroup;

class FaqGroupDetailsDTOFactory
{
    public const CONTEXT_FAQS = 'faqs';

    public function fromEntity(FaqGroup $faqGroup, array $context = []): FaqGroupDetailsDTO
    {
        return new FaqGroupDetailsDTO(
            $faqGroup->getId(),
            $faqGroup->getTitle(),
            $context[self::CONTEXT_FAQS] ?? [],
        );
    }
}
