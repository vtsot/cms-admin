<?php

declare(strict_types=1);

namespace App\DTO\Entity\Faq;

use App\DTOFactory\Entity\Faq\FaqGroupDTOFactory;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

/**
 * @see FaqGroupDTOFactory
 */
readonly class FaqGroupDTO
{
    public function __construct(
        #[OA\Property(type: 'string')]
        #[Groups(['faq_group_collection', 'faq_group_details'])]
        public Uuid $id,
        #[Groups(['faq_group_collection', 'faq_group_details'])]
        public ?string $title,
    ) {
    }
}
