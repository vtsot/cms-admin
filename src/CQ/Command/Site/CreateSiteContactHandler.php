<?php

declare(strict_types=1);

namespace App\CQ\Command\Site;

use App\Contract\MessageHandler\CommandHandlerInterface;
use App\CQ\Event\Site\SiteContactCreatedEvent;
use App\Entity\Contact;
use App\Exception\Validation\EntityNotFoundException;
use App\Repository\Site\SiteRepository;
use App\Service\MessageBusHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

use function strip_tags;

readonly class CreateSiteContactHandler implements CommandHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private TranslatorInterface $translator,
        private SiteRepository $siteRepository,
        private MessageBusHandler $messageBusHandler,
    ) {
    }

    public function __invoke(CreateSiteContactCommand $command): void
    {
        $site = $this->siteRepository->findOneActiveByTokenAndId($command->siteToken, $command->siteId);

        if ($site === null) {
            throw new EntityNotFoundException($this->translator->trans('SITE.NOT_FOUND'));
        }

        // create
        $contact = (new Contact())
            ->setSite($site)
            ->setName($command->name)
            ->setEmail($command->email)
            ->setMessage($command->message ? strip_tags($command->message) : null);

        // save
        $this->em->persist($contact);
        $this->em->flush();

        // created
        $this->messageBusHandler->handleEvent(
            new SiteContactCreatedEvent($contact->getId(), $site->getId(), $site->getToken()),
        );
    }
}
