<?php

declare(strict_types=1);

namespace App\DTO\Collection;

use App\DTO\Entity\Page\SitemapItemDTO;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Attribute\Groups;

readonly class SitemapCollectionDTO
{
    public function __construct(
        /** @var SitemapItemDTO[] */
        #[Groups(['sitemap_collection'])]
        #[OA\Property(
            type: 'array',
            items: new OA\Items(
                ref: new Model(
                    type: SitemapItemDTO::class,
                    groups: ['sitemap_collection'],
                )),
        )]
        public array $items,
    ) {
    }
}
