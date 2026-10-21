<?php

declare(strict_types=1);

namespace App\CQ\Command\Site;

use App\Contract\MessageHandler\CommandHandlerInterface;
use App\Exception\Validation\EntityNotFoundException;
use App\Exception\Validation\InvalidArgumentException;
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
        $site = $this->siteRepository->findOneById($command->siteId);

        if ($site === null) {
            throw new EntityNotFoundException($this->translator->trans('SITE.NOT_FOUND'));
        }

        $page = $this->pageRepository->findOneById($command->pageId);

        if ($page === null) {
            throw new EntityNotFoundException($this->translator->trans('PAGE.NOT_FOUND'));
        }

        if (!$command->siteId->equals($page->getSite()?->getId())) {
            throw new InvalidArgumentException(
                $this->translator->trans(
                    'PAGE.NOT_FOR_SITE',
                    [
                        '%PAGE%' => $page->getSlug() ?? $page->getId()?->toString(),
                        '%SITE%' => $site->getDomain() ?? $page->getId()?->toString(),
                    ]
                )
            );
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
