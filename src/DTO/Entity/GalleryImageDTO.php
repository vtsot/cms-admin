<?php

declare(strict_types=1);

namespace App\DTO\Entity;

use App\DTO\Data\LinkDTO;
use App\DTOFactory\Entity\GalleryImageDTOFactory;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

/**
 * @see GalleryImageDTOFactory
 */
readonly class GalleryImageDTO
{
    public function __construct(
        #[Groups(['gallery_image_collection', 'gallery_image_details'])]
        #[OA\Property(type: 'string', format: 'uuid')]
        public Uuid $id,

        #[Groups(['gallery_image_collection', 'gallery_image_details'])]
        public ?string $title,

        #[Groups(['gallery_image_collection', 'gallery_image_details'])]
        public ?string $alt,

        #[Groups(['gallery_image_collection', 'gallery_image_details'])]
        public ?string $image,

        #[Groups(['gallery_image_collection', 'gallery_image_details'])]
        public ?string $thumbnail,

        #[Groups(['gallery_image_collection', 'gallery_image_details'])]
        public ?string $color,

        #[Groups(['gallery_image_collection', 'gallery_image_details'])]
        public ?string $shape,

        #[Groups(['gallery_image_collection', 'gallery_image_details'])]
        public ?string $imprint,

        #[Groups(['gallery_image_collection', 'gallery_image_details'])]
        public ?string $content,

        #[Groups(['gallery_image_collection', 'gallery_image_details'])]
        public ?LinkDTO $link,
    ) {
    }
}
