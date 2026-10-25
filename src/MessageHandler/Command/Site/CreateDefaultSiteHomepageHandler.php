<?php

declare(strict_types=1);

namespace App\MessageHandler\Command\Site;

use App\Contract\MessageHandler\CommandHandlerInterface;
use App\Entity\Page\Page;
use App\Exception\Validation\EntityNotFoundException;
use App\Message\Command\Site\CreateDefaultSiteHomepageCommand;
use App\Repository\Site\SiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class CreateDefaultSiteHomepageHandler implements CommandHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private TranslatorInterface $translator,
        private SiteRepository $siteRepository,
    ) {
    }

    public function __invoke(CreateDefaultSiteHomepageCommand $command): void
    {
        if (!$site = $this->siteRepository->findOneById($command->siteId)) {
            throw new EntityNotFoundException($this->translator->trans(id: 'SITE.NOT_FOUND', domain: 'validators'));
        }

        $page = new Page()
            ->setHomepage(true)
            ->setTitle('Welcome')
            ->setSlug('homepage')
            ->setSite($site);

        $this->em->persist($page);
        $this->em->flush();
    }
}
