<?php

declare(strict_types=1);

namespace App\CQ\Command\Site;

use App\Contract\Dictionary\Review\ReviewRateType;
use App\Contract\MessageHandler\CommandHandlerInterface;
use App\Exception\Validation\EntityNotFoundException;
use App\Exception\Validation\InvalidArgumentException;
use App\Repository\Review\ReviewRepository;
use App\Repository\Site\SiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class UpdateSiteReviewFeedbackHandler implements CommandHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private TranslatorInterface $translator,
        private SiteRepository $siteRepository,
        private ReviewRepository $reviewRepository,
    ) {
    }

    public function __invoke(UpdateSiteReviewFeedbackCommand $command): void
    {
        $site = $this->siteRepository->findOneActiveByTokenAndId($command->siteToken, $command->siteId);

        if ($site === null) {
            throw new EntityNotFoundException($this->translator->trans('SITE.NOT_FOUND'));
        }

        $review = $this->reviewRepository->findOneById($command->reviewId);

        if ($review === null) {
            throw new EntityNotFoundException($this->translator->trans('REVIEW.NOT_FOUND'));
        }

        if (!$command->siteId->equals($review->getSite()?->getId())) {
            throw new InvalidArgumentException(
                $this->translator->trans(
                    'REVIEW.NOT_FOR_SITE',
                    [
                        '%REVIEW%' => $review->getBriefInfo() ?? $review->getId()?->toString(),
                        '%SITE%'   => $site->getDomain() ?? $review->getId()?->toString(),
                    ]
                )
            );
        }

        match ($command->feedbackType) {
            ReviewRateType::Like    => $review->setLikeQuantity($review->getLikeQuantity() + 1),
            ReviewRateType::Dislike => $review->setDislikeQuantity($review->getDislikeQuantity() + 1),
            ReviewRateType::Report  => $review->setReportQuantity($review->getReportQuantity() + 1),
        };

        $this->em->flush();
    }
}
