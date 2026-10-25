<?php

declare(strict_types=1);

namespace App\MessageHandler\Query\Site;

use App\Contract\MessageHandler\QueryHandlerInterface;
use App\DTO\Entity\Page\ArticleDetailsDTO;
use App\DTO\Entity\Page\PageDetailsDTO;
use App\DTOFactory\Entity\Page\ArticleDetailsDTOFactory;
use App\DTOFactory\Entity\Page\PageDetailsDTOFactory;
use App\Entity\Page\AbstractPage;
use App\Entity\Page\Article;
use App\Entity\Page\Page;
use App\Exception\Security\AccessDeniedException;
use App\Exception\Validation\EntityNotFoundException;
use App\Message\Query\Site\GetSitePageDetailsQuery;
use App\Repository\Page\AbstractPageRepository;
use App\Repository\Page\PageRelatedArticleRepository;
use App\Security\Voter\ApiSite\PageVoter;
use App\Security\Voter\VoterSubject;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class GetSitePageDetailsHandler implements QueryHandlerInterface
{
    public function __construct(
        private Security $security,
        private TranslatorInterface $translator,
        private AbstractPageRepository $pageRepository,
        private PageDetailsDTOFactory $pageDTOFactory,
        private ArticleDetailsDTOFactory $articleDTOFactory,
        private PageRelatedArticleRepository $pageRelatedArticleRepository,
    ) {
    }

    public function __invoke(GetSitePageDetailsQuery $query): PageDetailsDTO|ArticleDetailsDTO
    {
        /** @var Page|Article $page @ */
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
            PageDetailsDTOFactory::CONTEXT_RELATED_ARTICLES_TITLE => $relatedArticlesTitle,
            PageDetailsDTOFactory::CONTEXT_RELATED_ARTICLES_ITEMS => $relatedArticlesItems,
        ];

        return $this->pageDTOFactory->fromEntity($page, $context);
    }

    /**
     * @return array{
     *     0: string|null,
     *     1: array<int, ArticleDetailsDTO>,
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
