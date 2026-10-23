<?php

declare(strict_types=1);

namespace App\DTOFactory\Entity\Page;

use App\DTO\Entity\Page\SitemapItemDTO;
use App\Entity\Page\AbstractPage;

readonly class SitemapDTOFactory
{
    public function fromEntity(AbstractPage $page): SitemapItemDTO
    {
        return new SitemapItemDTO(
            $page->getId(),
            $page->getSlug(),
            $page->isHomepage(),
            $page->isIndexed(),
            $page->getSitemapChangeFrequency(),
            $page->getSitemapPriority(),
            $page->getUpdatedAt() ?? $page->getCreatedAt()
        );
    }
}
