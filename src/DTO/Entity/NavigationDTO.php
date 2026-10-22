<?php

declare(strict_types=1);

namespace App\DTO\Entity;

use App\DTO\Data\LinkDTO;
use App\DTOFactory\Entity\Navigation\NavigationDTOFactory;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

/**
 * @see NavigationDTOFactory
 */
readonly class NavigationDTO
{
    public function __construct(
        #[Groups(['navigation_collection', 'navigation_details'])]
        #[OA\Property(type: 'string', format: 'uuid')]
        public Uuid $id,

        #[Groups(['navigation_collection', 'navigation_details'])]
        public ?string $title,

        #[Groups(['navigation_collection', 'navigation_details'])]
        public ?LinkDTO $link,

        #[Groups(['navigation_collection', 'navigation_details'])]
        public array $children = [],
    ) {
    }
}
