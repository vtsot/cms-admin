<?php

declare(strict_types=1);

namespace App\DTOFactory\Entity\Site;

use App\Contract\Dictionary\NavigationType;
use App\DTO\Entity\Site\SiteDTO;
use App\Entity\Site\Site;

readonly class SiteDTOFactory
{
    public const string CONTEXT_HOMEPAGE_SLUG   = 'homepage-slug';
    public const string CONTEXT_MAIN_NAVIGATION = NavigationType::Main->value;

    public function fromEntity(Site $site, array $context = []): SiteDTO
    {
        return new SiteDTO(
            id: $site->getId(),
            domain: $site->getDomain(),
            title: $site->getTitle(),
            description: $site->getDescription(),
            homepage: $context[self::CONTEXT_HOMEPAGE_SLUG] ?? null,
            mainNavigation: $context[self::CONTEXT_MAIN_NAVIGATION] ?? [],
        );
    }
}
