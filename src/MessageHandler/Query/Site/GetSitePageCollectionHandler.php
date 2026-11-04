<?php

declare(strict_types=1);

namespace App\MessageHandler\Query\Site;

use App\Contract\MessageHandler\QueryHandlerInterface;
use App\DTO\Collection\Meta\CollectionFiltersDTO;
use App\DTO\Collection\Meta\CollectionMetaDTO;
use App\DTO\Collection\Meta\CollectionPaginatorDTO;
use App\DTO\Collection\PageInfoCollectionDTO;
use App\DTOFactory\Entity\Page\ArticleInfoDTOFactory;
use App\DTOFactory\Entity\Page\PageInfoDTOFactory;
use App\Entity\Page\AbstractPage;
use App\Entity\Page\Article;
use App\Entity\Page\Page;
use App\Exception\Security\AccessDeniedException;
use App\Exception\Validation\EntityNotFoundException;
use App\Message\Query\Site\GetSitePageCollectionQuery;
use App\Repository\Page\AbstractPageRepository;
use App\Repository\Site\SiteRepository;
use App\Security\Voter\ApiSite\PageVoter;
use App\Security\Voter\VoterSubject;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class GetSitePageCollectionHandler implements QueryHandlerInterface
{
    public function __construct(
        private Security $security,
        private TranslatorInterface $translator,
        private SiteRepository $siteRepository,
        private AbstractPageRepository $pageRepository,
        private PageInfoDTOFactory $pageInfoDTOFactory,
        private ArticleInfoDTOFactory $articleInfoDTOFactory,
    ) {
    }

    public function __invoke(GetSitePageCollectionQuery $query): PageInfoCollectionDTO
    {
        $siteId = $query->user->siteId;
        $token  = $query->user->token;

        if (!$site = $this->siteRepository->findOneActiveBySiteIdAndToken($siteId, $token)) {
            throw new EntityNotFoundException($this->translator->trans(id: 'SITE.NOT_FOUND', domain: 'validators'));
        }

        if (!$this->security->isGranted(PageVoter::LIST, new VoterSubject($siteId, AbstractPage::class))) {
            throw new AccessDeniedException($this->translator->trans(id: 'SECURITY.ACCESS_DENIED', domain: 'security'));
        }

        $items    = [];
        $criteria = $query->criteria;
        $page     = $this->pageRepository->findAllPaginatedBySiteIdAndToken($siteId, $token, $criteria);

        foreach ($page->getItems() as $item) {
            match (true) {
                $item instanceof Page    => $items[] = $this->pageInfoDTOFactory->fromEntity($item),
                $item instanceof Article => $items[] = $this->articleInfoDTOFactory->fromEntity($item),
                default                  => static fn () => null,
            };
        }

        $availableSortBy  = $criteria->availableSortBy();
        $availableFilters = $criteria->availableFilters();
        $appliedFilters   = $criteria->appliedFilters();

        return new PageInfoCollectionDTO(
            items: $items,
            meta: new CollectionMetaDTO(
                paginator: new CollectionPaginatorDTO(
                    page: $criteria->page,
                    perPage: $criteria->perPage,
                    total: $page->getTotalCount(),
                ),
                filters: new CollectionFiltersDTO(
                    query: $criteria->query,
                    sort: $criteria->filtersSort(),
                    availableSortBy: $availableSortBy,
                    availableFilters: $availableFilters,
                    appliedFilters: $appliedFilters,
                ),
            ),
        );
    }
}
