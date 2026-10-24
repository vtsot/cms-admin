<?php

declare(strict_types=1);

namespace App\DTO\Data;

use App\DTOFactory\Data\SitemapDTOFactory;
use Carbon\CarbonImmutable;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\Uuid;

/**
 * @see SitemapDTOFactory
 */
readonly class SitemapItemDTO
{
    public function __construct(
        #[Groups(['sitemap_collection'])]
        #[OA\Property(type: 'string', format: 'uuid')]
        public Uuid $id,

        #[Groups(['sitemap_collection'])]
        public ?string $slug = null,

        #[Groups(['sitemap_collection'])]
        public ?bool $isHomepage = false,

        #[Groups(['sitemap_collection'])]
        public bool $indexed = true,

        #[Groups(['sitemap_collection'])]
        public ?string $sitemapChangeFrequency = 'weekly',

        #[Groups(['sitemap_collection'])]
        public ?float $sitemapPriority = 0.5,

        #[Groups(['sitemap_collection'])]
        public ?CarbonImmutable $updatedAt = null,
    ) {
    }
}
