<?php

declare(strict_types=1);

namespace App\CQ\Query\Site;

use App\Contract\MessageHandler\QueryHandlerInterface;
use App\DTO\Collection\GalleryImageCollectionDTO;
use App\DTOFactory\Entity\GalleryImageDTOFactory;
use App\Exception\Validation\EntityNotFoundException;
use App\Repository\GalleryImageRepository;
use App\Repository\Site\SiteRepository;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class GetSiteGalleryImageCollectionHandler implements QueryHandlerInterface
{
    public function __construct(
        private TranslatorInterface $translator,
        private SiteRepository $siteRepository,
        private GalleryImageRepository $galleryImageRepository,
        private GalleryImageDTOFactory $galleryImageDTOFactory,
    ) {
    }

    public function __invoke(GetSiteGalleryImageCollectionQuery $query): GalleryImageCollectionDTO
    {
        $site = $this->siteRepository->findOneActiveByTokenAndId($query->siteToken, $query->siteId);

        if ($site === null) {
            throw new EntityNotFoundException($this->translator->trans('SITE.NOT_FOUND'));
        }

        $galleryImages = $this->galleryImageRepository->findAllActiveBySiteTokenAndSiteId($query->siteToken, $query->siteId);

        $items = [];

        foreach ($galleryImages as $item) {
            $items[] = $this->galleryImageDTOFactory->fromEntity($item);
        }

        return new GalleryImageCollectionDTO($items);
    }
}
