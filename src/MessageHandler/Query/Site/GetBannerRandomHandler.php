<?php

declare(strict_types=1);

namespace App\MessageHandler\Query\Site;

use App\Contract\MessageHandler\QueryHandlerInterface;
use App\DTO\Data\RandomItemDTO;
use App\DTO\Entity\Site\BannerDTO;
use App\DTOFactory\Entity\Site\BannerDTOFactory;
use App\Entity\Site\Banner;
use App\Exception\Security\AccessDeniedException;
use App\Exception\Validation\EntityNotFoundException;
use App\Message\Query\Site\GetBannerRandomQuery;
use App\Repository\Site\BannerRepository;
use App\Security\Voter\ApiSite\BannerVoter;
use App\Security\Voter\VoterSubject;
use App\Service\RandomizeService;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class GetBannerRandomHandler implements QueryHandlerInterface
{
    public function __construct(
        private Security $security,
        private TranslatorInterface $translator,
        private RandomizeService $randomizeService,
        private BannerRepository $bannerRepository,
        private BannerDTOFactory $bannerDTOFactory,
    ) {
    }

    public function __invoke(GetBannerRandomQuery $query): ?BannerDTO
    {
        if (!$banner = $this->resolveRandomBanner($query)) {
            throw new EntityNotFoundException($this->translator->trans(id: 'BANNER.NOT_FOUND', domain: 'validators'));
        }

        if (!$this->security->isGranted(BannerVoter::VIEW, new VoterSubject($query->siteId, $banner))) {
            throw new AccessDeniedException($this->translator->trans(id: 'SECURITY.ACCESS_DENIED', domain: 'security'));
        }

        return $this->bannerDTOFactory->fromEntity($banner);
    }

    private function resolveRandomBanner(GetBannerRandomQuery $query): ?Banner
    {
        $items   = [];
        $banners = $this->bannerRepository
            ->findAllActivePriorityBannersByActiveSiteIdAndToken($query->siteId, $query->token);

        foreach ($banners as $banner) {
            $items[] = new RandomItemDTO($banner['id'], $banner['priority']);
        }

        if ($randomItem = $this->randomizeService->getRandomItem($items)) {
            return $this->bannerRepository->findOneById(Uuid::fromString($randomItem->identifier));
        }

        return null;
    }
}
