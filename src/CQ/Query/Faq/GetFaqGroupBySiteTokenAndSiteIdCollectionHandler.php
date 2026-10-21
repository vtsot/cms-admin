<?php

declare(strict_types=1);

namespace App\CQ\Query\Faq;

use App\Contract\MessageHandler\QueryHandlerInterface;
use App\DTO\Collection\Faq\FaqGroupCollectionDTO;
use App\DTOFactory\Entity\Faq\FaqGroupDTOFactory;
use App\Exception\Validation\EntityNotFoundException;
use App\Repository\Faq\FaqGroupRepository;
use App\Repository\Site\SiteRepository;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class GetFaqGroupBySiteTokenAndSiteIdCollectionHandler implements QueryHandlerInterface
{
    public function __construct(
        private FaqGroupRepository $faqGroupRepository,
        private FaqGroupDTOFactory $faqGroupDTOFactory,
        private SiteRepository $siteRepository,
        private TranslatorInterface $translator,
    ) {
    }

    public function __invoke(GetFaqGroupBySiteTokenAndSiteIdCollectionQuery $query): FaqGroupCollectionDTO
    {
        $site = $this->siteRepository->findOneActiveByTokenAndId($query->siteToken, $query->siteId);

        if ($site === null) {
            throw new EntityNotFoundException($this->translator->trans('SITE.NOT_FOUND'));
        }

        $collection = $this->faqGroupRepository->findAllBySiteTokenAndSiteId($query->siteToken, $query->siteId);
        $items      = [];

        foreach ($collection as $item) {
            $items[] = $this->faqGroupDTOFactory->fromEntity($item);
        }

        return new FaqGroupCollectionDTO($items);
    }
}
