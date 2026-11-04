<?php

declare(strict_types=1);

namespace App\DTOFactory\Entity\Page;

use App\DTO\Entity\Page\ArticleInfoDTO;
use App\Entity\Page\Article;
use App\Service\CmsEmbed\Helper\CmsEmbedRenderer;

use function trim;

readonly class ArticleInfoDTOFactory
{
    public function __construct(
        private CmsEmbedRenderer $cmsEmbedRenderer,
        private ArticleDetailsDTOFactory $articleDetailsDTOFactory,
    ) {
    }

    public function fromEntity(Article $article): ArticleInfoDTO
    {
        $content = $article->getContent() ? $this->cmsEmbedRenderer->render($article->getContent()) : null;

        return new ArticleInfoDTO(
            id: $article->getId(),
            slug: $article->getSlug(),
            title: $article->getTitle(),
            imageAlt: $article->getImageAlt(),
            image: $this->articleDetailsDTOFactory->getDesktopImage($article),
            description: $article->getDescription(),
            content: $content ? trim($content) : null,
            sources: $article->getSources(),
        );
    }
}
