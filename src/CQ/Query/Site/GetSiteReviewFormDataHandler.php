<?php

declare(strict_types=1);

namespace App\CQ\Query\Site;

use App\Contract\MessageHandler\QueryHandlerInterface;
use App\CQ\Query\PaginatorTrait;
use App\DTO\Data\ReviewFormAuthorGenderItemDTO;
use App\DTO\Data\ReviewFormAuthorTypeItemDTO;
use App\DTO\Data\ReviewFormDataDTO;
use App\DTO\Entity\Review\AgeReviewQuestionItemDTO;
use App\DTO\Entity\Review\MedicationTimeReviewQuestionItemDTO;
use App\DTO\Entity\Review\ProductReviewQuestionItemDTO;
use App\DTO\Entity\Review\ReasonReviewQuestionItemDTO;
use App\DTOFactory\Data\ReviewFormAuthorGenderItemDTOFactory;
use App\DTOFactory\Data\ReviewFormAuthorTypeItemDTOFactory;
use App\DTOFactory\Entity\Review\AgeReviewQuestionItemDTOFactory;
use App\DTOFactory\Entity\Review\MedicationTimeReviewQuestionItemDTOFactory;
use App\DTOFactory\Entity\Review\ProductReviewQuestionItemDTOFactory;
use App\DTOFactory\Entity\Review\ReasonReviewQuestionItemDTOFactory;
use App\Exception\Validation\EntityNotFoundException;
use App\Repository\Review\AgeReviewQuestionItemRepository;
use App\Repository\Review\MedicationTimeReviewQuestionItemRepository;
use App\Repository\Review\ProductReviewQuestionItemRepository;
use App\Repository\Review\ReasonReviewQuestionItemRepository;
use App\Repository\Site\SiteRepository;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class GetSiteReviewFormDataHandler implements QueryHandlerInterface
{
    use PaginatorTrait;

    public function __construct(
        private TranslatorInterface $translator,
        private SiteRepository $siteRepository,
        private AgeReviewQuestionItemRepository $ageReviewQuestionItemRepository,
        private AgeReviewQuestionItemDTOFactory $ageReviewQuestionItemDTOFactory,
        private MedicationTimeReviewQuestionItemRepository $medicationTimeReviewQuestionItemRepository,
        private MedicationTimeReviewQuestionItemDTOFactory $medicationTimeReviewQuestionItemDTOFactory,
        private ReasonReviewQuestionItemRepository $reasonReviewQuestionItemRepository,
        private ReasonReviewQuestionItemDTOFactory $reasonReviewQuestionItemDTOFactory,
        private ReviewFormAuthorGenderItemDTOFactory $reviewFormAuthorGenderItemDTOFactory,
        private ReviewFormAuthorTypeItemDTOFactory $reviewFormAuthorTypeItemDTOFactory,
        private ProductReviewQuestionItemRepository $productReviewQuestionItemRepository,
        private ProductReviewQuestionItemDTOFactory $productReviewQuestionItemDTOFactory,
    ) {
    }

    public function __invoke(GetSiteReviewFormDataQuery $query): ReviewFormDataDTO
    {
        $site = $this->siteRepository->findOneActiveByTokenAndId($query->siteToken, $query->siteId);

        if ($site === null) {
            throw new EntityNotFoundException($this->translator->trans('SITE.NOT_FOUND'));
        }

        [
            $ageItems,
            $medicationTimeItems,
            $reasonItems,
            $authorGenderItems,
            $authorTypeItems,
            $productItems,
        ] = $this->resolveReviewItems($query->siteId);

        return new ReviewFormDataDTO(
            ageItems: $ageItems,
            medicationTimeItems: $medicationTimeItems,
            reasonItems: $reasonItems,
            authorGenderItems: $authorGenderItems,
            authorTypeItems: $authorTypeItems,
            productItems: $productItems,
        );
    }

    /**
     * @return array{
     *     0: array<int, AgeReviewQuestionItemDTO>,
     *     1: array<int, MedicationTimeReviewQuestionItemDTO>,
     *     2: array<int, ReasonReviewQuestionItemDTO>,
     *     3: array<int, ReviewFormAuthorGenderItemDTO>,
     *     4: array<int, ReviewFormAuthorTypeItemDTO>,
     *     4: array<int, ProductReviewQuestionItemDTO>,
     * }
     */
    private function resolveReviewItems(Uuid $siteId): array
    {
        $ageItems            = [];
        $medicationTimeItems = [];
        $reasonItems         = [];
        $authorGenderItems   = $this->reviewFormAuthorGenderItemDTOFactory->fromCaseCollection();
        $authorTypeItems     = $this->reviewFormAuthorTypeItemDTOFactory->fromCaseCollection();
        $productItems        = [];

        foreach ($this->ageReviewQuestionItemRepository->findAllActiveBySiteId($siteId) as $entity) {
            $ageItems[] = $this->ageReviewQuestionItemDTOFactory->fromEntity($entity);
        }

        foreach ($this->medicationTimeReviewQuestionItemRepository->findAllActiveBySiteId($siteId) as $entity) {
            $medicationTimeItems[] = $this->medicationTimeReviewQuestionItemDTOFactory->fromEntity($entity);
        }

        foreach ($this->reasonReviewQuestionItemRepository->findAllActiveBySiteId($siteId) as $entity) {
            $reasonItems[] = $this->reasonReviewQuestionItemDTOFactory->fromEntity($entity);
        }

        foreach ($this->productReviewQuestionItemRepository->findAllActiveBySiteId($siteId) as $entity) {
            $productItems[] = $this->productReviewQuestionItemDTOFactory->fromEntity($entity);
        }

        return [$ageItems, $medicationTimeItems, $reasonItems, $authorGenderItems, $authorTypeItems, $productItems];
    }
}
