<?php

declare(strict_types=1);

namespace App\DTO\Collection;

use App\DTO\Entity\NavigationDTO;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Groups;

readonly class NavigationTreeCollectionDTO
{
    public function __construct(
        /** @var NavigationDTO[] */
        #[Groups(['navigation_collection'])]
        #[OA\Property(
            type: 'array',
            items: new OA\Items(
                ref: new Model(
                    type: NavigationDTO::class,
                    groups: ['navigation_collection'],
                )),
        )]
        public array $items,
    ) {
    }
}
