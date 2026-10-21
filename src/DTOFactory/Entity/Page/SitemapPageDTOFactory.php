<?php

declare(strict_types=1);

namespace App\DTOFactory\Entity\Page;

use App\DTO\Entity\Page\SitemapPageDTO;
use App\Entity\Page\AbstractPage;
use Ramsey\Uuid\Uuid;

readonly class SitemapPageDTOFactory
{
    public function fromEntity(AbstractPage $page): SitemapPageDTO
    {
        $id = $page->getId() ?? Uuid::fromString(Uuid::NIL);

        return new SitemapPageDTO(
            $id,
            $page->getSlug(),
            $page->isHomepage(),
            $page->isIndexed(),
            $page->getSitemapChangeFrequency(),
            $page->getSitemapPriority(),
            $page->getUpdatedAt() ?? $page->getCreatedAt()
        );
    }
}
