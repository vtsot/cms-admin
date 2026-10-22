<?php

declare(strict_types=1);

namespace App\DTOFactory\Entity\Site;

use App\Contract\Dictionary\NavigationType;
use App\DTO\Entity\Site\SiteDTO;

readonly class SiteDTOFactory
{
    public const CONTEXT_HOMEPAGE_SLUG = 'homepage-slug';
    //    public const CONTEXT_NAVIGATION_TOP    = NavigationType::Top->value;
    //    public const CONTEXT_NAVIGATION_BOTTOM = NavigationType::Bottom->value;

    public function __construct(
    ) {
    }

    public function fromEntity(Site $site, array $context = []): SiteDTO
    {
        return new SiteDTO(
            $site->getId(),
            $site->getDomain(),
            null,
            $site->getTitle(),
            null,
            null,
            null,
            null,
            null,
            $context[self::CONTEXT_HOMEPAGE_SLUG] ?? null,
            [], // $context[self::CONTEXT_NAVIGATION_TOP] ?? [],
            [], // $context[self::CONTEXT_NAVIGATION_BOTTOM] ?? [],
        );
    }
}
