<?php

declare(strict_types=1);

namespace App\EntityListener;

use App\Contract\Entity\EntityListenerInterface;
use App\CQ\Command\SetMaximumPositionNumberCommand;
use App\Entity\AbstractEntity;
use App\Entity\Faq\Faq;
use App\Entity\GalleryImage;
use App\Entity\Navigation\BottomNavigation;
use App\Entity\Navigation\TopNavigation;
use App\Entity\Page\PageRelatedArticle;
use App\Entity\Review\AgeReviewQuestionItem;
use App\Entity\Review\MedicationTimeReviewQuestionItem;
use App\Entity\Review\ReasonReviewQuestionItem;
use App\Service\MessageBusHandler;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Throwable;

#[AsEntityListener(event: Events::postPersist, method: 'postPersist', entity: TopNavigation::class)]
#[AsEntityListener(event: Events::postPersist, method: 'postPersist', entity: BottomNavigation::class)]
#[AsEntityListener(event: Events::postPersist, method: 'postPersist', entity: PageRelatedArticle::class)]
#[AsEntityListener(event: Events::postPersist, method: 'postPersist', entity: GalleryImage::class)]
#[AsEntityListener(event: Events::postPersist, method: 'postPersist', entity: Faq::class)]
#[AsEntityListener(event: Events::postPersist, method: 'postPersist', entity: AgeReviewQuestionItem::class)]
#[AsEntityListener(event: Events::postPersist, method: 'postPersist', entity: ReasonReviewQuestionItem::class)]
#[AsEntityListener(event: Events::postPersist, method: 'postPersist', entity: MedicationTimeReviewQuestionItem::class)]
final readonly class PositionEntityListener implements EntityListenerInterface
{
    public function __construct(
        private MessageBusHandler $messageBusHandler,
    ) {
    }

    public function postPersist(AbstractEntity $entity): void
    {
        try {
            $this->messageBusHandler->handleCommand(new SetMaximumPositionNumberCommand($entity));
        } catch (Throwable $e) {
        }
    }
}
