<?php

declare(strict_types=1);

namespace App\DTO\Entity\Page;

use App\DTOFactory\Entity\Page\PageDTOFactory;
use Carbon\CarbonImmutable;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

/**
 * @see PageDTOFactory
 */
readonly class SitemapPageDTO
{
    public function __construct(
        #[Groups(['sitemap_page_collection'])]
        #[OA\Property(type: 'string', format: 'uuid')]
        public Uuid $id,

        #[Groups(['sitemap_page_collection'])]
        public ?string $slug = null,

        #[Groups(['sitemap_page_collection'])]
        public ?bool $isHomepage = false,

        #[Groups(['sitemap_page_collection'])]
        public bool $indexed = true,

        #[Groups(['sitemap_page_collection'])]
        public ?string $sitemapChangeFrequency = 'weekly',

        #[Groups(['sitemap_page_collection'])]
        public ?float $sitemapPriority = 0.5,

        #[Groups(['sitemap_page_collection'])]
        public ?CarbonImmutable $updatedAt = null,
    ) {
    }
}
