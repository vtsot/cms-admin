<?php

declare(strict_types=1);

namespace App\DTOFactory\Entity\Faq;

use App\DTO\Entity\Faq\FaqGroupDTO;
use App\Entity\Faq\FaqGroup;

class FaqGroupDTOFactory
{
    public function fromEntity(FaqGroup $faqGroup): FaqGroupDTO
    {
        return new FaqGroupDTO(
            $faqGroup->getId(),
            $faqGroup->getTitle(),
        );
    }
}
