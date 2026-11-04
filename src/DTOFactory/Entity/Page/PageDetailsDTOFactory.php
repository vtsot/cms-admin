<?php

declare(strict_types=1);

namespace App\DTOFactory\Entity\Page;

use App\Contract\Dictionary\PageType;
use App\DTO\Entity\Page\PageDetailsDTO;
use App\Entity\Page\Page;
use App\Service\CmsEmbed\Helper\CmsEmbedRenderer;

readonly class PageDetailsDTOFactory
{
    public const string CONTEXT_RELATED_ARTICLES_TITLE = 'related-articles-title';
    public const string CONTEXT_RELATED_ARTICLES_ITEMS = 'related-articles-items';

    public function __construct(
        private CmsEmbedRenderer $cmsEmbedRenderer,
    ) {
    }

    public function fromEntity(Page $page, array $context = []): PageDetailsDTO
    {
        $content = $page->getContent() ? $this->cmsEmbedRenderer->render($page->getContent()) : null;

        return new PageDetailsDTO(
            id: $page->getId(),
            slug: $page->getSlug(),
            type: PageType::Page,
            isHomepage: $page->isHomepage(),
            title: $page->getTitle(),
            content: $content ? trim($content) : null,
            relatedArticlesTitle: $context[self::CONTEXT_RELATED_ARTICLES_TITLE] ?? null,
            relatedArticles: $context[self::CONTEXT_RELATED_ARTICLES_ITEMS] ?? [],
            sources: $page->getSources(),
            redirect: $page->getRedirect(),
            codeBlock: $page->getCodeBlock(),
            metaTitle: $page->getMetaTitle(),
            metaKeywords: $page->getMetaKeywords(),
            metaDescription: $page->getMetaDescription(),
            ogTitle: $page->getOgTitle(),
            ogDescription: $page->getOgDescription(),
            ogImage: $page->getOgImage(),
            indexed: $page->isIndexed(),
            sitemapChangeFrequency: $page->getSitemapChangeFrequency(),
            sitemapPriority: $page->getSitemapPriority(),
        );
    }
}
