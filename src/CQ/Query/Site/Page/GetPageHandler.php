<?php

declare(strict_types=1);

namespace App\CQ\Query\Site\Page;

use App\Contract\MessageHandler\QueryHandlerInterface;
use App\DTO\Entity\Page\ArticleDTO;
use App\DTO\Entity\Page\PageDTO;
use App\DTOFactory\Entity\Page\ArticleDTOFactory;
use App\DTOFactory\Entity\Page\PageDTOFactory;
use App\Entity\Page\AbstractPage;
use App\Entity\Page\Article;
use App\Entity\Page\Page;
use App\Exception\Security\AccessDeniedException;
use App\Exception\Validation\EntityNotFoundException;
use App\Repository\Page\AbstractPageRepository;
use App\Repository\Page\PageRelatedArticleRepository;
use App\Security\Voter\ApiSite\PageVoter;
use App\Security\Voter\VoterSubject;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class GetPageHandler implements QueryHandlerInterface
{
    public function __construct(
        private Security $security,
        private TranslatorInterface $translator,
        private AbstractPageRepository $pageRepository,
        private PageDTOFactory $pageDTOFactory,
        private ArticleDTOFactory $articleDTOFactory,
        private PageRelatedArticleRepository $pageRelatedArticleRepository,
    ) {
    }

    public function __invoke(GetPageQuery $query): PageDTO|ArticleDTO
    {
        if (!$page = $this->pageRepository->findOneActiveBySiteIdAndTokenAndSlug($query->siteId, $query->token, $query->slug)) {
            throw new EntityNotFoundException($this->translator->trans(id: 'GENERAL.NOT_FOUND', domain: 'validators'));
        }

        if (!$this->security->isGranted(PageVoter::VIEW, new VoterSubject($query->siteId, $page))) {
            throw new AccessDeniedException($this->translator->trans(id: 'SECURITY.ACCESS_DENIED', domain: 'security'));
        }

        if ($page instanceof Article) {
            return $this->articleDTOFactory->fromEntity($page);
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
            $items               = [];
            $pageRelatedArticles = $this->pageRelatedArticleRepository->findAllActiveByPageId($page->getId());

            foreach ($pageRelatedArticles as $item) {
                if ($item->getArticle() !== null) {
                    $items[] = $this->articleDTOFactory->fromEntity($item->getArticle());
                }
            }

            return [$page->getRelatedArticlesTitle(), $items];
        }

        return [null, []];
    }
}
