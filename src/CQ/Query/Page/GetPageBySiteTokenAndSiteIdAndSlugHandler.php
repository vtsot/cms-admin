<?php

declare(strict_types=1);

namespace App\CQ\Query\Page;

use App\Contract\MessageHandler\QueryHandlerInterface;
use App\DTO\Collection\PageRelatedArticleCollectionDTO;
use App\DTO\Entity\Page\ArticleDTO;
use App\DTO\Entity\Page\PageDTO;
use App\DTOFactory\Entity\Page\PageDTOFactory;
use App\Entity\Page\AbstractPage;
use App\Entity\Page\Page;
use App\Exception\Validation\EntityNotFoundException;
use App\Repository\Page\AbstractPageRepository;
use App\Service\MessageBusHandler;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class GetPageBySiteTokenAndSiteIdAndSlugHandler implements QueryHandlerInterface
{
    public function __construct(
        private TranslatorInterface $translator,
        private MessageBusHandler $messageBusHandler,
        private AbstractPageRepository $abstractPageRepository,
        private PageDTOFactory $pageDTOFactory,
    ) {
    }

    public function __invoke(GetPageBySiteTokenAndSiteIdAndSlugQuery $query): PageDTO
    {
        $page = $this
            ->abstractPageRepository
            ->findOneActiveBySiteTokenAndSiteIdAndSlug($query->siteToken, $query->siteId, $query->slug);

        if ($page === null) {
            throw new EntityNotFoundException($this->translator->trans('PAGE.NOT_FOUND'));
        }

        [$relatedArticlesTitle, $relatedArticlesItems] = $this->resolvePageRelatedArticles($page);

        $context = [
            PageDTOFactory::CONTEXT_RELATED_ARTICLES_TITLE => $relatedArticlesTitle,
            PageDTOFactory::CONTEXT_RELATED_ARTICLES_ITEMS => $relatedArticlesItems,
        ];

        return $this->pageDTOFactory->fromEntity($page, $context);
    }

    /**
     * @return array{
     *     0: string|null,
     *     1: array<int, ArticleDTO>,
     *  }
     */
    private function resolvePageRelatedArticles(AbstractPage $page): array
    {
        if ($page instanceof Page) {
            /** @var PageRelatedArticleCollectionDTO $collection */
            $collection = $this->messageBusHandler->handleQuery(new GetPageRelatedArticleCollectionQuery($page->getId()));
            $articles   = [];

            foreach ($collection->items as $pageRelatedArticleDTO) {
                $articles[] = $pageRelatedArticleDTO->article;
            }

            return [$page->getRelatedArticlesTitle(), $articles];
        }

        return [null, []];
    }
}
