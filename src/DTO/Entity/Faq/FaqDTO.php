<?php

declare(strict_types=1);

namespace App\DTO\Entity\Faq;

use App\DTOFactory\Entity\Faq\FaqDTOFactory;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

/**
 * @see FaqDTOFactory
 */
readonly class FaqDTO
{
    public function __construct(
        #[OA\Property(type: 'string')]
        #[Groups(['faq_collection', 'faq_details'])]
        public Uuid $id,
        #[Groups(['faq_collection', 'faq_details'])]
        public ?string $title,
        #[Groups(['faq_collection', 'faq_details'])]
        public ?string $content,
    ) {
    }
}
