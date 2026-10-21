<?php

declare(strict_types=1);

namespace App\DTOFactory\Entity\Faq;

use App\DTO\Entity\Faq\FaqDTO;
use App\Entity\Faq\Faq;

class FaqDTOFactory
{
    public function fromEntity(Faq $faq): FaqDTO
    {
        return new FaqDTO(
            $faq->getId(),
            $faq->getTitle(),
            $faq->getContent(),
        );
    }
}
