<?php

declare(strict_types=1);

namespace App\CQ\Command;

use App\Contract\MessageHandler\CommandHandlerInterface;
use App\Entity\Faq\Faq;
use App\Entity\GalleryImage;
use App\Entity\Navigation\AbstractNavigation;
use App\Entity\Page\PageRelatedArticle;
use App\Entity\Review\AbstractReviewQuestionItem;
use App\Repository\Faq\FaqRepository;
use App\Repository\Page\PageRelatedArticleRepository;
use Doctrine\ORM\EntityManagerInterface;

readonly class SetMaximumPositionNumberHandler implements CommandHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private PageRelatedArticleRepository $pageRelatedArticleRepository,
        private FaqRepository $faqRepository,
    ) {
    }

    public function __invoke(SetMaximumPositionNumberCommand $command): void
    {
        $entity      = $command->entity;
        $maxPosition = null;

        if ($entity instanceof AbstractNavigation && $entity->getSite()) {
            $maxPosition = $this->em->getRepository($entity::class)->getMaximumPositionForActiveItemsBySiteIdAndParent($entity->getSite()->getId(), $entity->getParent()?->getId());
        } elseif ($entity instanceof PageRelatedArticle && $entity->getPage()) {
            $maxPosition = $this->pageRelatedArticleRepository->getMaximumPositionForActiveItemsByPageId($entity->getPage()->getId());
        } elseif ($entity instanceof Faq && $entity->getFaqGroup()) {
            $maxPosition = $this->faqRepository->getMaximumPositionForActiveItemsByFaqGroupId($entity->getFaqGroup()->getId());
        } elseif (($entity instanceof GalleryImage || $entity instanceof AbstractReviewQuestionItem) && $entity->getSite()) {
            $maxPosition = $this->em->getRepository($entity::class)->getMaximumPositionForActiveItemsBySiteId($entity->getSite()->getId());
        }

        if ($maxPosition !== null) {
            $entity->setPosition($maxPosition + 1);
            $this->em->persist($entity);
            $this->em->flush();
        }
    }
}
