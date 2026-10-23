<?php

declare(strict_types=1);

namespace App\DTO\Entity\Site;

use App\DTO\Data\LinkDTO;
use App\DTOFactory\Entity\Site\BannerDTOFactory;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Attribute\Groups;
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
        public ?string $title,

        #[Groups(['banner_collection', 'banner_details'])]
        public ?string $imageAlt,

        #[Groups(['banner_collection', 'banner_details'])]
        public ?string $desktopImage,

        #[Groups(['banner_collection', 'banner_details'])]
        public ?string $mobileImage,

        #[Groups(['banner_collection', 'banner_details'])]
        public ?LinkDTO $link,
    ) {
    }
}
