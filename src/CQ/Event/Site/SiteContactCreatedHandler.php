<?php

declare(strict_types=1);

namespace App\CQ\Event\Site;

use App\Contract\MessageHandler\EventHandlerInterface;
use App\CQ\Command\Site\Email\SendSiteContactEmailCommand;
use App\Service\MessageBusHandler;

readonly class SiteContactCreatedHandler implements EventHandlerInterface
{
    public function __construct(
        private MessageBusHandler $messageBusHandler,
    ) {
    }

    public function __invoke(SiteContactCreatedEvent $event): void
    {
        $this->messageBusHandler->handleCommand(
            new SendSiteContactEmailCommand($event->contactId, $event->siteId, $event->siteToken),
        );
    }
}
