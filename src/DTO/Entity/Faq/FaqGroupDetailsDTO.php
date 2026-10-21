<?php

declare(strict_types=1);

namespace App\DTO\Entity\Faq;

use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

/**
 * @see FaqGroupDetailsDTOFactory
 */
readonly class FaqGroupDetailsDTO
{
    public function __construct(
        #[OA\Property(type: 'string')]
        #[Groups(['faq_group_details'])]
        public Uuid $id,

        #[Groups(['faq_group_details'])]
        public ?string $title,

        /** @var FaqDTO[] $faqs */
        #[Groups(['faq_group_details'])]
        public array $faqs,
    ) {
    }
}
