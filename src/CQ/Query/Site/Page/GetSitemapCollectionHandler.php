<?php

declare(strict_types=1);

namespace App\CQ\Query\Site\Page;

use App\Contract\MessageHandler\QueryHandlerInterface;
use App\DTO\Collection\SitemapCollectionDTO;
use App\DTOFactory\Data\SitemapDTOFactory;
use App\Entity\Page\AbstractPage;
use App\Exception\Security\AccessDeniedException;
use App\Exception\Validation\EntityNotFoundException;
use App\Repository\Page\AbstractPageRepository;
use App\Repository\Site\SiteRepository;
use App\Security\Voter\ApiSite\PageVoter;
use App\Security\Voter\VoterSubject;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class GetSitemapCollectionHandler implements QueryHandlerInterface
{
    public function __construct(
        private Security $security,
        private TranslatorInterface $translator,
        private SiteRepository $siteRepository,
        private AbstractPageRepository $pageRepository,
        private SitemapDTOFactory $sitemapPageDTOFactory,
    ) {
    }

    public function __invoke(GetSitemapCollectionQuery $query): SitemapCollectionDTO
    {
        if (!$site = $this->siteRepository->findOneActiveBySiteIdAndToken($query->siteId, $query->token)) {
            throw new EntityNotFoundException($this->translator->trans(id: 'GENERAL.NOT_FOUND', domain: 'validators'));
        }

        if (!$this->security->isGranted(PageVoter::LIST, new VoterSubject($query->siteId, AbstractPage::class))) {
            throw new AccessDeniedException($this->translator->trans(id: 'SECURITY.ACCESS_DENIED', domain: 'security'));
        }

        $items = [];
        $pages = $this->pageRepository->findAllActiveForIndexing($query->siteId, $query->token);

        foreach ($pages as $item) {
            $items[] = $this->sitemapPageDTOFactory->fromEntity($item);
        }

        return new SitemapCollectionDTO($items);
    }
}
