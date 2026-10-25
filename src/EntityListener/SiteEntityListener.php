<?php

declare(strict_types=1);

namespace App\EntityListener;

use App\Contract\Entity\EntityListenerInterface;
use App\Entity\Site\Site;
use App\Message\Command\Site\CreateDefaultSiteHomepageCommand;
use App\Message\Command\Site\ResetSiteTokenCommand;
use App\Service\MessageBusHandler;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Throwable;

#[AsEntityListener(event: Events::postPersist, method: 'postPersist', entity: Site::class)]
final readonly class SiteEntityListener implements EntityListenerInterface
{
    public function __construct(
        private MessageBusHandler $messageBusHandler,
    ) {
    }

    public function postPersist(Site $site): void
    {
        try {
            $this->messageBusHandler->handleCommand(new ResetSiteTokenCommand($site->getId()));
            $this->messageBusHandler->handleCommand(new CreateDefaultSiteHomepageCommand($site->getId()));
        } catch (Throwable $e) {
        }
    }
}
