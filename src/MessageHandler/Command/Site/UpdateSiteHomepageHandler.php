<?php

declare(strict_types=1);

namespace App\MessageHandler\Command\Site;

use App\Contract\MessageHandler\CommandHandlerInterface;
use App\Exception\Validation\EntityNotFoundException;
use App\Message\Command\Site\UpdateSiteHomepageCommand;
use App\Repository\Page\PageRepository;
use App\Repository\Site\SiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class UpdateSiteHomepageHandler implements CommandHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private TranslatorInterface $translator,
        private SiteRepository $siteRepository,
        private PageRepository $pageRepository,
    ) {
    }

    public function __invoke(UpdateSiteHomepageCommand $command): void
    {
        if (!$site = $this->siteRepository->findOneById($command->siteId)) {
            throw new EntityNotFoundException($this->translator->trans(id: 'SITE.NOT_FOUND', domain: 'validators'));
        }

        if (!$this->pageRepository->findOneById($command->pageId)) {
            throw new EntityNotFoundException($this->translator->trans(id: 'PAGE.NOT_FOUND', domain: 'validators'));
        }

        if (!$page = $this->pageRepository->findOneBySiteIdAndPageId($command->siteId, $command->pageId)) {
            throw new EntityNotFoundException($this->translator->trans(
                id: 'PAGE.NOT_FOUND_FOR_SITE',
                parameters: [
                    '%PAGE%' => $page->getTitle() ?? $page->getSlug(),
                    '%SITE%' => $site->getDomain(),
                ],
                domain: 'validators',
            ));
        }

        // reset homepages marker
        $pages = $this->pageRepository->findAllBySiteId($site->getId());

        foreach ($pages as $existPage) {
            $existPage->setHomepage(false);
        }

        // set homepage
        $page
            ->setHomepage(true)
            ->setActive(true);

        // save
        $this->em->flush();
    }
}
