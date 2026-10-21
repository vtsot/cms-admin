<?php

declare(strict_types=1);

namespace App\CQ\Command\Site;

use App\Contract\MessageHandler\CommandHandlerInterface;
use App\DTO\Entity\Review\ReviewDTO;
use App\DTOFactory\Entity\Review\ReviewDTOFactory;
use App\Entity\Review\Review;
use App\Exception\Validation\EntityNotFoundException;
use App\Repository\Review\AgeReviewQuestionItemRepository;
use App\Repository\Review\MedicationTimeReviewQuestionItemRepository;
use App\Repository\Review\ProductReviewQuestionItemRepository;
use App\Repository\Review\ReasonReviewQuestionItemRepository;
use App\Repository\Site\SiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class CreateSiteReviewHandler implements CommandHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private TranslatorInterface $translator,
        private SiteRepository $siteRepository,
        private ReasonReviewQuestionItemRepository $reasonReviewQuestionItemRepository,
        private AgeReviewQuestionItemRepository $ageReviewQuestionItemRepository,
        private MedicationTimeReviewQuestionItemRepository $medicationTimeReviewQuestionItemRepository,
        private ReviewDTOFactory $reviewDTOFactory,
        private ProductReviewQuestionItemRepository $productReviewQuestionItemRepository,
    ) {
    }

    public function __invoke(CreateSiteReviewCommand $command): ReviewDTO
    {
        $site = $this->siteRepository->findOneActiveByTokenAndId($command->siteToken, $command->siteId);

        if ($site === null) {
            throw new EntityNotFoundException($this->translator->trans('SITE.NOT_FOUND'));
        }

        $reason = $command->reasonId
            ? $this->reasonReviewQuestionItemRepository->findOneActiveByIdAndSiteId($command->reasonId, $command->siteId)
            : null;

        if ($reason === null) {
            throw new EntityNotFoundException($this->translator->trans('REASON_REVIEW_QUESTION_ITEM.NOT_FOUND'));
        }

        $authorAge = $command->authorAgeId
            ? $this->ageReviewQuestionItemRepository->findOneActiveByIdAndSiteId($command->authorAgeId, $command->siteId)
            : null;

        if ($authorAge === null) {
            throw new EntityNotFoundException($this->translator->trans('AGE_REVIEW_QUESTION_ITEM.NOT_FOUND'));
        }

        $medicationTime = $command->medicationTimeId
            ? $this->medicationTimeReviewQuestionItemRepository->findOneActiveByIdAndSiteId($command->medicationTimeId, $command->siteId)
            : null;

        if ($medicationTime === null) {
            throw new EntityNotFoundException($this->translator->trans('MEDICATION_TIME_REVIEW_QUESTION_ITEM.NOT_FOUND'));
        }

        $product = null;

        if ($command->productId) {
            $product = $this->productReviewQuestionItemRepository->findOneActiveByIdAndSiteId($command->productId, $command->siteId);

            if ($product === null) {
                throw new EntityNotFoundException($this->translator->trans('PRODUCT_REVIEW_QUESTION_ITEM.NOT_FOUND'));
            }
        }

        // create
        $review = (new Review())
            ->setSite($site)
            ->setActive(false)
            ->setReason($reason)
            ->setAuthorName($command->authorName)
            ->setAuthorGender($command->authorGender)
            ->setAuthorType($command->authorType)
            ->setAuthorAge($authorAge)
            ->setMedicationTime($medicationTime)
            ->setEffectiveness($command->effectiveness)
            ->setEaseOfUse($command->easeOfUse)
            ->setSatisfaction($command->satisfaction)
            ->setContent($command->content ? strip_tags($command->content) : null)
            ->setFullName($command->fullName)
            ->setEmail($command->email)
            ->setProduct($product)
            ->setOtherProductName($command->otherProductName)
            ->setOtherProductManufacturer($command->otherProductManufacturer);

        // save
        $this->em->persist($review);
        $this->em->flush();

        return $this->reviewDTOFactory->fromEntity($review);
    }
}
