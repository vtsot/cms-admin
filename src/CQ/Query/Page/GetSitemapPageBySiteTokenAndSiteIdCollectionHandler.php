<?php

declare(strict_types=1);

namespace App\CQ\Query\Page;

use App\Contract\MessageHandler\QueryHandlerInterface;
use App\DTO\Collection\SitemapPageCollectionDTO;
use App\DTOFactory\Entity\Page\SitemapPageDTOFactory;
use App\Exception\Validation\EntityNotFoundException;
use App\Repository\Page\AbstractPageRepository;
use App\Repository\Site\SiteRepository;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class GetSitemapPageBySiteTokenAndSiteIdCollectionHandler implements QueryHandlerInterface
{
    public function __construct(
        private TranslatorInterface $translator,
        private AbstractPageRepository $abstractPageRepository,
        private SitemapPageDTOFactory $sitemapPageDTOFactory,
        private SiteRepository $siteRepository,
    ) {
    }

    public function __invoke(GetSitemapPageBySiteTokenAndSiteIdCollectionQuery $query): SitemapPageCollectionDTO
    {
        $site = $this->siteRepository->findOneActiveByTokenAndId($query->siteToken, $query->siteId);

        if ($site === null) {
            throw new EntityNotFoundException($this->translator->trans('SITE.NOT_FOUND'));
        }

        $pages = $this->abstractPageRepository->findAllActiveForIndexing($query->siteToken, $query->siteId);
        $items = [];

        foreach ($pages as $item) {
            $items[] = $this->sitemapPageDTOFactory->fromEntity($item);
        }

        return new SitemapPageCollectionDTO($items);
    }
}
