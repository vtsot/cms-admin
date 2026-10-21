<?php

declare(strict_types=1);

namespace App\DTOFactory\Entity\Page;

use App\DTO\Entity\Page\PageRelatedArticleDTO;
use App\Entity\Page\PageRelatedArticle;

readonly class PageRelatedArticleDTOFactory
{
    public function __construct(
        private ArticleDTOFactory $articleDTOFactory,
    ) {
    }

    public function fromEntity(PageRelatedArticle $pageRelatedArticle): PageRelatedArticleDTO
    {
        return new PageRelatedArticleDTO(
            $pageRelatedArticle->getId(),
            $this->articleDTOFactory->fromEntity($pageRelatedArticle->getArticle()),
        );
    }
}
