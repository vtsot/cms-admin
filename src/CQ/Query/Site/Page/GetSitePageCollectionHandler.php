<?php

declare(strict_types=1);

namespace App\CQ\Query\Site\Page;

use App\Contract\Dictionary\PageSitemapChangeFrequency;
use App\Contract\Dictionary\PageSitemapPriority;
use App\Contract\Dictionary\PageType;
use App\Contract\MessageHandler\QueryHandlerInterface;
use App\CQ\Query\Site\Page\Traits\FiltersOrderByTrait;
use App\DTO\Collection\Meta\CollectionFiltersDTO;
use App\DTO\Collection\Meta\CollectionMetaDTO;
use App\DTO\Collection\Meta\CollectionPaginatorDTO;
use App\DTO\Collection\PageInfoCollectionDTO;
use App\DTOFactory\Entity\Page\ArticleInfoDTOFactory;
use App\DTOFactory\Entity\Page\PageInfoDTOFactory;
use App\Entity\Page\AbstractPage;
use App\Exception\Security\AccessDeniedException;
use App\Exception\Validation\EntityNotFoundException;
use App\Repository\Page\AbstractPageRepository;
use App\Repository\Site\SiteRepository;
use App\Security\Voter\ApiSite\PageVoter;
use App\Security\Voter\VoterSubject;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class GetSitePageCollectionHandler implements QueryHandlerInterface
{
    use FiltersOrderByTrait;

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
        if (!$site = $this->siteRepository->findOneActiveBySiteIdAndToken($query->siteId, $query->token)) {
            throw new EntityNotFoundException($this->translator->trans(id: 'GENERAL.NOT_FOUND', domain: 'validators'));
        }

        if (!$this->security->isGranted(PageVoter::LIST, new VoterSubject($query->siteId, AbstractPage::class))) {
            throw new AccessDeniedException($this->translator->trans(id: 'SECURITY.ACCESS_DENIED', domain: 'security'));
        }

        $items    = [];
        $criteria = $query->criteria;
        $page     = $this->pageRepository->getAllPaginatedBySiteIdAndToken($query->siteId, $query->token, $criteria);

        foreach ($page->getItems() as $item) {
            match ($criteria->type) {
                PageType::Page    => $items[] = $this->pageInfoDTOFactory->fromEntity($item),
                PageType::Article => $items[] = $this->articleInfoDTOFactory->fromEntity($item),
            };
        }

        $availableSortBy                            = array_keys($query::SORT_BY);
        $availableFilters                           = $query::FILTERS;
        $availableFilters[$query::FILTER_TYPE]      = PageType::valueNames();
        $availableFilters[$query::FILTER_FREQUENCY] = PageSitemapChangeFrequency::valueNames();
        $availableFilters[$query::FILTER_PRIORITY]  = PageSitemapPriority::valueNames();

        $appliedFilters = [
            $query::FILTER_TYPE      => $criteria->type->value,
            $query::FILTER_QUERY     => $criteria->query,
            $query::FILTER_SLUG      => $criteria->slug,
            $query::FILTER_ACTIVE    => $criteria->active,
            $query::FILTER_START_DAY => $criteria->startDay?->format('Y-m-d'),
            $query::FILTER_END_DAY   => $criteria->endDay?->format('Y-m-d'),
            $query::FILTER_INDEXED   => $criteria->indexed,
            $query::FILTER_FREQUENCY => $criteria->frequency,
            $query::FILTER_PRIORITY  => $criteria->priority,
        ];

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
                    sort: $this->resolveFiltersOrderBy($criteria->orderBy, $criteria->orderDirection, $query::SORT_BY),
                    availableSortBy: $availableSortBy,
                    availableFilters: $availableFilters,
                    appliedFilters: $appliedFilters,
                ),
            ),
        );
    }
}
