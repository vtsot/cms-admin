<?php

declare(strict_types=1);

namespace App\MessageHandler\Query\Site\Page;

use App\Contract\MessageHandler\QueryHandlerInterface;
use App\DTO\Entity\Page\ArticleDetailsDTO;
use App\DTO\Entity\Page\PageDetailsDTO;
use App\DTOFactory\Entity\Page\ArticleInfoDTOFactory;
use App\DTOFactory\Entity\Page\PageDetailsDTOFactory;
use App\Entity\Page\AbstractPage;
use App\Entity\Page\Article;
use App\Entity\Page\Page;
use App\Exception\Security\AccessDeniedException;
use App\Exception\Validation\EntityNotFoundException;
use App\Message\Query\Site\Page\GetSitePageDetailsQuery;
use App\Repository\Page\PageRelatedArticleRepository;
use App\Repository\Page\PageRepository;
use App\Security\Voter\ApiSite\PageVoter;
use App\Security\Voter\VoterSubject;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class GetSitePageDetailsHandler implements QueryHandlerInterface
{
    public function __construct(
        private Security $security,
        private TranslatorInterface $translator,
        private PageRepository $pageRepository,
        private PageDetailsDTOFactory $pageDetailsDTOFactory,
        private PageRelatedArticleRepository $pageRelatedArticleRepository,
        private ArticleInfoDTOFactory $articleInfoDTOFactory,
    ) {
    }

    public function __invoke(GetSitePageDetailsQuery $query): PageDetailsDTO|ArticleDetailsDTO
    {
        $siteId = $query->user->siteId;
        $token  = $query->user->token;

        /** @var Page|Article $page @ */
        if (!$page = $this->pageRepository->findOneActiveBySiteIdAndTokenAndSlug($siteId, $token, $query->slug)) {
            throw new EntityNotFoundException($this->translator->trans(id: 'PAGE.NOT_FOUND', domain: 'validators'));
        }

        if (!$this->security->isGranted(PageVoter::VIEW, new VoterSubject($siteId, $page))) {
            throw new AccessDeniedException($this->translator->trans(id: 'SECURITY.ACCESS_DENIED', domain: 'security'));
        }

        [$relatedArticlesTitle, $relatedArticlesItems] = $this->resolvePageRelatedArticles($page);

        $context = [
            PageDetailsDTOFactory::CONTEXT_RELATED_ARTICLES_TITLE => $relatedArticlesTitle,
            PageDetailsDTOFactory::CONTEXT_RELATED_ARTICLES_ITEMS => $relatedArticlesItems,
        ];

        return $this->pageDetailsDTOFactory->fromEntity($page, $context);
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
                    $items[] = $this->articleInfoDTOFactory->fromEntity($item->getArticle());
                }
            }

            return [$page->getRelatedArticlesTitle(), $items];
        }

        return [null, []];
    }
}
