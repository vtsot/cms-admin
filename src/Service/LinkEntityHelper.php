<?php

declare(strict_types=1);

namespace App\Service;

use App\Contract\Entity\LinkEntityInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LinkEntityHelper
{
    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public function getPrimaryLinkUrl(
        LinkEntityInterface $linkEntity,
        ?int $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH,
    ): ?string {
        return $this->doGetLinkEntityUrl($linkEntity, $referenceType);
    }

    private function doGetLinkEntityUrl(
        LinkEntityInterface $linkEntity,
        ?int $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH,
    ): ?string {
        return match ($linkEntity->getLinkType()) {
            // link to the local site page
            LinkEntityInterface::LINK_TYPE_PAGE => $linkEntity->getLinkPage()?->getSlug()
                ? $this->urlGenerator->generate(
                    'web.cms',
                    ['slug' => $linkEntity->getLinkPage()?->getSlug()],
                    $referenceType
                )
                : null,

            // link to the external site
            LinkEntityInterface::LINK_TYPE_EXTERNAL_LINK => $linkEntity->getLinkUrl(),

            // by default link not set
            default => null,
        };
    }
}
