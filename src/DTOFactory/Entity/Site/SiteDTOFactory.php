<?php

declare(strict_types=1);

namespace App\DTOFactory\Entity\Site;

use App\Contract\Dictionary\NavigationType;
use App\DTO\Entity\Site\SiteDTO;
use App\Entity\Brand;
use App\Entity\GenericName;
use App\Entity\Site\Site;
use Ramsey\Uuid\Uuid;

use function array_filter;
use function array_map;
use function array_unique;
use function array_values;
use function implode;

readonly class SiteDTOFactory
{
    public const CONTEXT_HOMEPAGE_SLUG = 'homepage-slug';
    //    public const CONTEXT_NAVIGATION_TOP    = NavigationType::Top->value;
    //    public const CONTEXT_NAVIGATION_BOTTOM = NavigationType::Bottom->value;

    public function __construct(
        private SiteThemeDTOFactory $siteThemeDTOFactory,
    ) {
    }

    public function fromEntity(Site $site, array $context = []): SiteDTO
    {
        $id        = $site->getId() ?? Uuid::fromString(Uuid::NIL);
        $siteTheme = $site->getSiteTheme()
            ? $this->siteThemeDTOFactory->fromEntity($site->getSiteTheme(), $context)
            : null;

        $genericNames = array_values(array_unique(array_map(
            static fn (GenericName $genericName) => $genericName->getName(),
            $site->getGenericNames()->toArray()
        )));

        $brandNames = array_values(array_unique(array_map(
            static fn (Brand $brand) => $brand->getName(),
            $site->getBrands()->toArray()
        )));

        return new SiteDTO(
            $id,
            $site->getDomain(),
            $siteTheme,
            $site->getTitle(),
            $genericNames ? implode(' ', array_filter($genericNames)) : null,
            $brandNames ? implode(' ', array_filter($brandNames)) : null,
            $site->getFooterText1(),
            $site->getFooterText2(),
            $site->getCopyrightText(),
            $context[self::CONTEXT_HOMEPAGE_SLUG] ?? null,
            $context[self::CONTEXT_NAVIGATION_TOP] ?? [],
            $context[self::CONTEXT_NAVIGATION_BOTTOM] ?? [],
        );
    }
}
