<?php

declare(strict_types=1);

namespace App\CQ\Query\Site;

use App\Contract\Dictionary\NavigationType;
use App\Contract\MessageHandler\QueryHandlerInterface;
use App\CQ\Query\Site\Navigation\GetSiteNavigationTreeQuery;
use App\DTO\Collection\NavigationTreeCollectionDTO;
use App\DTO\Entity\Site\SiteDTO;
use App\DTOFactory\Data\LinkDTOFactory;
use App\DTOFactory\Entity\Site\SiteDTOFactory;
use App\Exception\Validation\EntityNotFoundException;
use App\Repository\Page\PageRepository;
use App\Repository\Site\SiteRepository;
use App\Service\MessageBusHandler;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class GetSiteByTokenAndIdHandler implements QueryHandlerInterface
{
    public function __construct(
        private TranslatorInterface $translator,
        private MessageBusHandler $messageBusHandler,
        private PageRepository $pageRepository,
        private SiteRepository $siteRepository,
        private SiteDTOFactory $siteDTOFactory,
        private LinkDTOFactory $linkDTOFactory,
    ) {
    }

    public function __invoke(GetSiteByTokenAndIdQuery $query): SiteDTO
    {
        $site = $this->siteRepository->findOneActiveByTokenAndId($query->siteToken, $query->siteId);

        if ($site === null) {
            throw new EntityNotFoundException($this->translator->trans('SITE.NOT_FOUND'));
        }

        $homepage         = $this->pageRepository->findHomepageBySiteId($query->siteId);
        $navigationTop    = $this->resolveSiteNavigation($query->siteToken, $query->siteId, NavigationType::Top);
        $navigationBottom = $this->resolveSiteNavigation($query->siteToken, $query->siteId, NavigationType::Bottom);
        $isThemeReview    = $site->getSiteTheme()?->getCode() === SiteTheme::THEME_REVIEW;

        $context = [
            SiteDTOFactory::CONTEXT_HOMEPAGE_SLUG        => $homepage?->getSlug(),
            SiteDTOFactory::CONTEXT_NAVIGATION_TOP       => $navigationTop->items ?: [],
            SiteDTOFactory::CONTEXT_NAVIGATION_BOTTOM    => $navigationBottom->items ?: [],
            SiteThemeDTOFactory::CONTEXT_FAVICON         => $site->getSettings()?->getFavicon(),
            SiteThemeDTOFactory::CONTEXT_IMAGE_POSITION  => $isThemeReview ? $site->getSettings()?->getImagePosition() : null,
            SiteThemeDTOFactory::CONTEXT_IMAGE_TITLE     => $isThemeReview ? $site->getSettings()?->getImageTitle() : null,
            SiteThemeDTOFactory::CONTEXT_LINK_TITLE      => $isThemeReview && $site->getSettings()?->isLinkActive() ? $site->getSettings()?->getLinkTitle() : null,
            SiteThemeDTOFactory::CONTEXT_LINK            => $isThemeReview && $site->getSettings()?->isLinkActive() ? $this->linkDTOFactory->fromEntity($site->getSettings()) : null,
            SiteThemeDTOFactory::CONTEXT_DESKTOP_IMAGE   => $isThemeReview ? $site->getSettings()?->getDesktopImage() : null,
            SiteThemeDTOFactory::CONTEXT_MOBILE_IMAGE    => $isThemeReview ? $site->getSettings()?->getMobileImage() : null,
            SiteThemeDTOFactory::CONTEXT_PRIMARY_COLOR   => $site->getSettings()?->getThemePrimaryColor(),
            SiteThemeDTOFactory::CONTEXT_TEXT_COLOR      => $site->getSettings()?->getThemeTextColor(),
            SiteThemeDTOFactory::CONTEXT_TOP_BG_COLOR    => $site->getSettings()?->getThemeTopBgColor(),
            SiteThemeDTOFactory::CONTEXT_FOOTER_BG_COLOR => $site->getSettings()?->getThemeFooterBgColor(),
        ];

        return $this->siteDTOFactory->fromEntity($site, $context);
    }

    private function resolveSiteNavigation(string $siteToken, Uuid $siteId, NavigationType $type): NavigationTreeCollectionDTO
    {
        return $this->messageBusHandler->handleQuery(new GetSiteNavigationTreeQuery($siteToken, $siteId, $type));
    }
}
