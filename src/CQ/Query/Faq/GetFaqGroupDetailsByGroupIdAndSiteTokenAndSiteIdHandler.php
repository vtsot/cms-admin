<?php

declare(strict_types=1);

namespace App\CQ\Query\Faq;

use App\Contract\MessageHandler\QueryHandlerInterface;
use App\DTO\Entity\Faq\FaqGroupDetailsDTO;
use App\DTOFactory\Entity\Faq\FaqDTOFactory;
use App\DTOFactory\Entity\Faq\FaqGroupDetailsDTOFactory;
use App\Exception\Validation\EntityNotFoundException;
use App\Repository\Faq\FaqGroupRepository;
use App\Repository\Faq\FaqRepository;
use App\Repository\Site\SiteRepository;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class GetFaqGroupDetailsByGroupIdAndSiteTokenAndSiteIdHandler implements QueryHandlerInterface
{
    public function __construct(
        private SiteRepository $siteRepository,
        private FaqRepository $faqRepository,
        private FaqDTOFactory $faqDTOFactory,
        private TranslatorInterface $translator,
        private FaqGroupRepository $faqGroupRepository,
        private FaqGroupDetailsDTOFactory $faqGroupDetailsDTOFactory,
    ) {
    }

    public function __invoke(GetFaqGroupDetailsByGroupIdAndSiteTokenAndSiteIdQuery $query): FaqGroupDetailsDTO
    {
        $site = $this->siteRepository->findOneActiveByTokenAndId($query->siteToken, $query->siteId);

        if ($site === null) {
            throw new EntityNotFoundException($this->translator->trans('SITE.NOT_FOUND'));
        }

        $faqGroup = $this->faqGroupRepository->findOneBySiteTokenAndSiteIdAndId($query->siteToken, $query->siteId, $query->faqGroupId);

        if ($faqGroup === null) {
            throw new EntityNotFoundException($this->translator->trans('FAQ_GROUP.NOT_FOUND'));
        }

        $collection = $this->faqRepository->findAllActiveBySiteTokenAndSiteIdAndGroupId($query->siteToken, $query->siteId, $query->faqGroupId);

        $items = [];

        foreach ($collection as $item) {
            $items[] = $this->faqDTOFactory->fromEntity($item);
        }

        $context = [
            FaqGroupDetailsDTOFactory::CONTEXT_FAQS => $items,
        ];

        return $this->faqGroupDetailsDTOFactory->fromEntity($faqGroup, $context);
    }
}
