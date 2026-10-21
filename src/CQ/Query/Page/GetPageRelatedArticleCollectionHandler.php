<?php

declare(strict_types=1);

namespace App\CQ\Query\Page;

use App\Contract\MessageHandler\QueryHandlerInterface;
use App\DTO\Collection\PageRelatedArticleCollectionDTO;
use App\DTOFactory\Entity\Page\PageRelatedArticleDTOFactory;
use App\Repository\Page\PageRelatedArticleRepository;

readonly class GetPageRelatedArticleCollectionHandler implements QueryHandlerInterface
{
    public function __construct(
        private PageRelatedArticleRepository $pageRelatedArticleRepository,
        private PageRelatedArticleDTOFactory $pageRelatedArticleDTOFactory,
    ) {
    }

    public function __invoke(GetPageRelatedArticleCollectionQuery $query): PageRelatedArticleCollectionDTO
    {
        $pageRelatedArticles = $this->pageRelatedArticleRepository->findAllActiveByPageId($query->pageId);

        $items = [];

        foreach ($pageRelatedArticles as $item) {
            if ($item->getArticle() !== null) {
                $items[] = $this->pageRelatedArticleDTOFactory->fromEntity($item);
            }
        }

        return new PageRelatedArticleCollectionDTO($items);
    }
}
