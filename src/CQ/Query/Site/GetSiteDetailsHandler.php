<?php

declare(strict_types=1);

namespace App\CQ\Query\Site;

use App\Contract\Dictionary\NavigationType;
use App\Contract\MessageHandler\QueryHandlerInterface;
use App\CQ\Query\Site\Navigation\GetNavigationTreeQuery;
use App\DTO\Collection\NavigationTreeCollectionDTO;
use App\DTO\Entity\Site\SiteDTO;
use App\DTOFactory\Entity\Site\SiteDTOFactory;
use App\Exception\Security\AccessDeniedException;
use App\Exception\Validation\EntityNotFoundException;
use App\Repository\Page\PageRepository;
use App\Repository\Site\SiteRepository;
use App\Security\Voter\ApiSite\SiteVoter;
use App\Security\Voter\VoterSubject;
use App\Service\MessageBusHandler;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class GetSiteDetailsHandler implements QueryHandlerInterface
{
    public function __construct(
        private Security $security,
        private TranslatorInterface $translator,
        private MessageBusHandler $messageBusHandler,
        private SiteRepository $siteRepository,
        private PageRepository $pageRepository,
        private SiteDTOFactory $siteDTOFactory,
    ) {
    }

    public function __invoke(GetSiteDetailsQuery $query): SiteDTO
    {
        if (!$site = $this->siteRepository->findOneActiveBySiteIdAndToken($query->siteId, $query->token)) {
            throw new EntityNotFoundException($this->translator->trans(id: 'GENERAL.NOT_FOUND', domain: 'validators'));
        }

        if (!$this->security->isGranted(SiteVoter::VIEW, new VoterSubject($query->siteId, $site))) {
            throw new AccessDeniedException($this->translator->trans(id: 'SECURITY.ACCESS_DENIED', domain: 'security'));
        }

        $homepage       = $this->pageRepository->findHomepageBySiteIdAndToken($query->siteId, $query->token);
        $mainNavigation = $this->resolveSiteNavigation($query->siteId, $query->token, NavigationType::Main);

        $context = [
            SiteDTOFactory::CONTEXT_HOMEPAGE_SLUG   => $homepage?->getSlug(),
            SiteDTOFactory::CONTEXT_MAIN_NAVIGATION => $mainNavigation->items,
        ];

        return $this->siteDTOFactory->fromEntity($site, $context);
    }

    private function resolveSiteNavigation(Uuid $siteId, string $token, NavigationType $type): NavigationTreeCollectionDTO
    {
        return $this->messageBusHandler->handleQuery(new GetNavigationTreeQuery($siteId, $token, $type));
    }
}
