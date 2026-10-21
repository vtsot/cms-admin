<?php

declare(strict_types=1);

namespace App\DTOFactory\Entity\Page;

use App\DTO\Entity\Page\PageDTO;
use App\Entity\Page\AbstractPage;
use App\Service\CmsEmbed\Helper\CmsEmbedRenderer;

readonly class PageDTOFactory
{
    public const CONTEXT_RELATED_ARTICLES_TITLE = 'related-articles-title';
    public const CONTEXT_RELATED_ARTICLES_ITEMS = 'related-articles-items';

    public function __construct(
        private CmsEmbedRenderer $cmsEmbedRenderer,
    ) {
    }

    public function fromEntity(AbstractPage $page, array $context = []): PageDTO
    {
        return new PageDTO(
            $page->getId(),
            $page->getSlug(),
            $page->isHomepage(),
            $page->getTitle(),
            $this->cmsEmbedRenderer->render($page->getContent()),
            $context[self::CONTEXT_RELATED_ARTICLES_TITLE] ?? null,
            $page->getSources(),
            $page->getRedirect(),
            $page->getCodeBlock(),
            $page->getMetaTitle(),
            $page->getMetaKeywords(),
            $page->getMetaDescription(),
            $page->getOgTitle(),
            $page->getOgDescription(),
            $page->getOgImage(),
            $page->isIndexed(),
            $page->getSitemapChangeFrequency(),
            $page->getSitemapPriority(),
            $context[self::CONTEXT_RELATED_ARTICLES_ITEMS] ?? [],
        );
    }
}
