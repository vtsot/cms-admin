<?php

declare(strict_types=1);

namespace App\DTO\Collection;

use App\DTO\Entity\Page\SitemapPageDTO;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Groups;

readonly class SitemapPageCollectionDTO
{
    public function __construct(
        /** @var SitemapPageDTO[] */
        #[Groups(['sitemap_page_collection'])]
        #[OA\Property(
            type: 'array',
            items: new OA\Items(
                ref: new Model(
                    type: SitemapPageDTO::class,
                    groups: ['sitemap_page_collection'],
                )),
        )]
        public array $items,
    ) {
    }
}
