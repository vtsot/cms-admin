<?php

declare(strict_types=1);

namespace App\CQ\Query\Site;

use App\Contract\Dictionary\Review\ReviewSortType;
use App\Contract\MessageHandler\QueryHandlerInterface;
use App\CQ\Query\PaginatorTrait;
use App\DTO\Collection\Meta\CollectionPaginatorDTO;
use App\DTO\Collection\Meta\ReviewCollectionMetaDTO;
use App\DTO\Collection\ReviewCollectionDTO;
use App\DTOFactory\Data\ReviewSortTypeDTOFactory;
use App\DTOFactory\Entity\Review\ReasonReviewQuestionItemDTOFactory;
use App\DTOFactory\Entity\Review\ReviewDTOFactory;
use App\Entity\Review\Review;
use App\Exception\Validation\EntityNotFoundException;
use App\Repository\Review\ReasonReviewQuestionItemRepository;
use App\Repository\Review\ReviewRepository;
use App\Repository\Site\SiteRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Contracts\Translation\TranslatorInterface;

use function count;

readonly class GetSiteReviewCollectionHandler implements QueryHandlerInterface
{
    use PaginatorTrait;

    public function __construct(
        private TranslatorInterface $translator,
        private SiteRepository $siteRepository,
        private ReviewRepository $reviewRepository,
        private ReviewDTOFactory $reviewDTOFactory,
        private ReviewSortTypeDTOFactory $reviewSortTypeDTOFactory,
        private ReasonReviewQuestionItemRepository $reasonReviewQuestionItemRepository,
        private ReasonReviewQuestionItemDTOFactory $reasonReviewQuestionItemDTOFactory,
    ) {
    }

    public function __invoke(GetSiteReviewCollectionQuery $query): ReviewCollectionDTO
    {
        $site = $this->siteRepository->findOneActiveByTokenAndId($query->siteToken, $query->siteId);

        if ($site === null) {
            throw new EntityNotFoundException($this->translator->trans('SITE.NOT_FOUND'));
        }

        $qb = $this->reviewRepository->createBaseQuery(
            siteToken: $query->siteToken,
            siteId: $query->siteId,
            active: true,
            alias: 'q',
            query: $query->query,
            reasonId: $query->reasonId,
        );

        // apply ordering
        match ($query->sortType) {
            ReviewSortType::MostHelpful        => $qb->orderBy('CAST(q.likeQuantity AS SIGNED) - CAST(q.dislikeQuantity AS SIGNED)', 'desc'),
            ReviewSortType::HighestTotalRating => $qb->orderBy('q.reportQuantity + q.easeOfUse + q.satisfaction', 'desc'),
            ReviewSortType::HighSatisfaction   => $qb->orderBy('q.satisfaction', 'desc'),
            ReviewSortType::LowSatisfaction    => $qb->orderBy('q.satisfaction', 'asc'),

            // ReviewSortType::MostRecent
            default => $qb->orderBy('q.createdAt', 'desc'),
        };

        // resolve $perPage
        $perPage = $query->perPage > 0 ? $query->perPage : count($qb->getQuery()->getResult());

        /** @var Paginator|Review[] $paginator */
        $paginator = $this->getPaginator($qb, $query->page, $perPage);

        $items = [];

        foreach ($paginator as $item) {
            $items[] = $this->reviewDTOFactory->fromEntity($item);
        }

        return new ReviewCollectionDTO(
            $items,
            new ReviewCollectionMetaDTO(
                paginator: new CollectionPaginatorDTO(
                    currentPage: $query->page,
                    itemsPerPage: $perPage,
                    totalItems: $paginator->count(),
                ),
                appliedSortType: $this->reviewSortTypeDTOFactory->fromType($query->sortType),
                sortTypes: $this->reviewSortTypeDTOFactory->fromCaseCollection(),
            )
        );
    }
}
