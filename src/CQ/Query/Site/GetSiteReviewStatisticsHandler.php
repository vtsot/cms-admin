<?php

declare(strict_types=1);

namespace App\CQ\Query\Site;

use App\Contract\MessageHandler\QueryHandlerInterface;
use App\DTO\Data\ReviewStatistics\ReviewStatisticsDTO;
use App\DTO\Data\ReviewStatistics\ReviewStatisticsMetaDTO;
use App\DTOFactory\Data\ReviewStatisticsParametersDTOFactory;
use App\DTOFactory\Entity\Review\ReasonReviewQuestionItemDTOFactory;
use App\Entity\Review\Review;
use App\Exception\Validation\EntityNotFoundException;
use App\Repository\Review\ReasonReviewQuestionItemRepository;
use App\Repository\Review\ReviewRepository;
use App\Repository\Site\SiteRepository;
use Symfony\Contracts\Translation\TranslatorInterface;

use function count;
use function range;
use function round;

readonly class GetSiteReviewStatisticsHandler implements QueryHandlerInterface
{
    private const PARAM_MOST_POPULAR_REVIEW  = 'mostPopularReview';
    private const PARAM_LEAST_POPULAR_REVIEW = 'leastPopularReview';

    public function __construct(
        private SiteRepository $siteRepository,
        private TranslatorInterface $translator,
        private ReviewRepository $reviewRepository,
        private ReviewStatisticsParametersDTOFactory $reviewStatisticsParametersDTOFactory,
        private ReasonReviewQuestionItemRepository $reasonReviewQuestionItemRepository,
        private ReasonReviewQuestionItemDTOFactory $reasonReviewQuestionItemDTOFactory,
    ) {
    }

    public function __invoke(GetSiteReviewStatisticsQuery $query): ReviewStatisticsDTO
    {
        $site = $this->siteRepository->findOneActiveByTokenAndId($query->siteToken, $query->siteId);

        if ($site === null) {
            throw new EntityNotFoundException($this->translator->trans('SITE.NOT_FOUND'));
        }

        $reasonItems   = [];
        $appliedReason = null;

        foreach ($this->reasonReviewQuestionItemRepository->findAllActiveWithReviewsQtyBySiteId($query->siteId) as $k => $entityArray) {
            $reasonItems[$k] = $this->reasonReviewQuestionItemDTOFactory->fromEntityArray($entityArray);

            if ($query->reasonId && $query->reasonId?->toString() === $entityArray['id']?->toString()) {
                $appliedReason = $reasonItems[$k];
            }
        }

        $statisticsData = $this->reviewRepository->getStatisticsForActiveReviewBySiteTokenAndSiteId(
            siteToken: $query->siteToken,
            siteId: $query->siteId,
            query: $query->query,
            reasonId: $query->reasonId,
        );

        $totalQty = $statisticsData['totalQty'] ?? 0;
        $indexes  = range(1, 5);
        $totalSum = 0;

        foreach (Review::EVALUATIVE_INDICATORS as $property) {
            $totalPropertySum = 0;

            foreach ($indexes as $ind) {
                $statisticsData["{$property}{$ind}Ratio"] = $totalQty ? round($statisticsData["{$property}{$ind}Qty"] * 100 / $totalQty, 1) : 0;
                $totalPropertySum += $ind * $statisticsData["{$property}{$ind}Qty"];
            }

            $statisticsData["{$property}Average"] = $totalQty ? round($totalPropertySum / $totalQty, 1) : 0;
            $totalSum += $statisticsData["{$property}Average"];
        }

        $statisticsData['totalAverage'] = round($totalSum / count(Review::EVALUATIVE_INDICATORS), 1);

        $mostLeastReviewParams = [
            self::PARAM_MOST_POPULAR_REVIEW  => 'desc',
            self::PARAM_LEAST_POPULAR_REVIEW => 'asc',
        ];

        foreach ($mostLeastReviewParams as $property => $order) {
            $statisticsData[$property] = $this->reviewRepository->getMostOrLeastActiveReviewBySiteTokenAndSiteId(
                siteToken: $query->siteToken,
                siteId: $query->siteId,
                query: $query->query,
                reasonId: $query->reasonId,
                order: $order,
                alias: 'r',
            );
        }

        if ($statisticsData[self::PARAM_LEAST_POPULAR_REVIEW]
            && $statisticsData[self::PARAM_LEAST_POPULAR_REVIEW]->getId() === $statisticsData[self::PARAM_MOST_POPULAR_REVIEW]?->getId()) {
            // most and least popular reviews are the same => delete the least popular review
            $statisticsData[self::PARAM_LEAST_POPULAR_REVIEW] = null;
        }

        return new ReviewStatisticsDTO(
            parameters: $this->reviewStatisticsParametersDTOFactory->fromArray($statisticsData),
            meta: new ReviewStatisticsMetaDTO(
                appliedReason: $appliedReason,
                reasons: $reasonItems,
            )
        );
    }
}
