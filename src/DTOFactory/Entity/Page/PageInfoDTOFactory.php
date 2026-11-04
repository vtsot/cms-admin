<?php

declare(strict_types=1);

namespace App\DTOFactory\Entity\Page;

use App\DTO\Entity\Page\PageInfoDTO;
use App\Entity\Page\Page;
use App\Service\CmsEmbed\Helper\CmsEmbedRenderer;

readonly class PageInfoDTOFactory
{
    public function __construct(
        private CmsEmbedRenderer $cmsEmbedRenderer,
    ) {
    }

    public function fromEntity(Page $page): PageInfoDTO
    {
        $content = $page->getContent() ? $this->cmsEmbedRenderer->render($page->getContent()) : null;

        return new PageInfoDTO(
            id: $page->getId(),
            slug: $page->getSlug(),
            isHomepage: $page->isHomepage(),
            title: $page->getTitle(),
            content: $content ? trim($content) : null,
            sources: $page->getSources(),
        );
    }
}
