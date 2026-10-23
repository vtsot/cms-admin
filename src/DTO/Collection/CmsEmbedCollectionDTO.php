<?php

declare(strict_types=1);

namespace App\DTO\Collection;

use App\DTO\CmsEmbed\CmsEmbedDTO;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Attribute\Groups;

readonly class CmsEmbedCollectionDTO
{
    public function __construct(
        /** @var CmsEmbedDTO[] */
        #[Groups(['cms_embed_collection'])]
        #[OA\Property(
            type: 'array',
            items: new OA\Items(
                ref: new Model(
                    type: CmsEmbedDTO::class,
                    groups: ['cms_embed_collection'],
                )),
        )]
        public array $items,
    ) {
    }
}
