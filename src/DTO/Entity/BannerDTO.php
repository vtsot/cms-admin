<?php

declare(strict_types=1);

namespace App\DTO\Entity;

use App\DTO\Data\LinkDTO;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

/**
 * @see BannerDTOFactory
 */
readonly class BannerDTO
{
    public function __construct(
        #[Groups(['banner_collection', 'banner_details'])]
        #[OA\Property(type: 'string', format: 'uuid')]
        public Uuid $id,

        #[Groups(['banner_collection', 'banner_details'])]
        public ?string $name,

        #[Groups(['banner_collection', 'banner_details'])]
        public ?string $alt,

        #[Groups(['banner_collection', 'banner_details'])]
        public ?string $desktopImage,

        #[Groups(['banner_collection', 'banner_details'])]
        public ?string $mobileImage,

        #[Groups(['banner_collection', 'banner_details'])]
        public ?LinkDTO $link,
    ) {
    }
}
