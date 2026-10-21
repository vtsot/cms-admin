<?php

declare(strict_types=1);

namespace App\CQ\Query\Site;

use App\Contract\MessageHandler\QueryHandlerInterface;
use App\DTO\Data\RandomItemDTO;
use App\DTO\Entity\BannerDTO;
use App\DTOFactory\Entity\BannerDTOFactory;
use App\Entity\Banner;
use App\Exception\Validation\EntityNotFoundException;
use App\Repository\BannerRepository;
use App\Service\RandomizeService;
use Ramsey\Uuid\Uuid;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class GetSiteRandomBannerHandler implements QueryHandlerInterface
{
    public function __construct(
        private TranslatorInterface $translator,
        private RandomizeService $randomizeService,
        private BannerRepository $bannerRepository,
        private BannerDTOFactory $bannerDTOFactory,
    ) {
    }

    public function __invoke(GetSiteRandomBannerQuery $query): ?BannerDTO
    {
        $banners = $this->bannerRepository->findAllActivePriorityBannersByActiveSiteIdAndSiteToken($query->siteId, $query->siteToken);
        $banner  = $this->resolveRandomBanner($banners);

        if ($banner === null) {
            throw new EntityNotFoundException($this->translator->trans('BANNER.NOT_FOUND'));
        }

        return $this->bannerDTOFactory->fromEntity($banner);
    }

    private function resolveRandomBanner(array $banners): ?Banner
    {
        $items = [];

        foreach ($banners as $banner) {
            $items[] = new RandomItemDTO($banner['id'], $banner['priority']);
        }

        if ($randomItem = $this->randomizeService->getRandomItem($items)) {
            return $this->bannerRepository->findOneById(Uuid::fromString($randomItem->identifier));
        }

        return null;
    }
}
