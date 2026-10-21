<?php

declare(strict_types=1);

namespace App\DTO\Collection;

use App\DTO\Entity\GalleryImageDTO;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Groups;

readonly class GalleryImageCollectionDTO
{
    public function __construct(
        /** @var GalleryImageDTO[] */
        #[Groups(['gallery_image_collection'])]
        #[OA\Property(
            type: 'array',
            items: new OA\Items(
                ref: new Model(
                    type: GalleryImageDTO::class,
                    groups: ['gallery_image_collection'],
                )),
        )]
        public array $items,
    ) {
    }
}
