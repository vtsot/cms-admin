<?php

declare(strict_types=1);

namespace App\DTOFactory\Data;

use App\Contract\Dictionary\Link\LinkTarget;
use App\Contract\Dictionary\Link\LinkType;
use App\Contract\Entity\LinkEntityInterface;
use App\DTO\Data\LinkDTO;

readonly class LinkDTOFactory
{
    public function fromEntity(LinkEntityInterface $entity): LinkDTO
    {
        // resolve slug
        $slug = match ($entity->getLinkType()) {
            LinkType::Page->value    => $entity->getLinkPage()?->getSlug(),
            LinkType::Article->value => $entity->getLinkArticle()?->getSlug(),
            default                  => null,
        };

        return new LinkDTO(
            url: $entity->getLinkType() === LinkType::Link->value ? $entity->getLinkUrl() : null,
            slug: $slug,
            type: $entity->getLinkType() ? LinkType::tryFrom($entity->getLinkType()) : null,
            target: $entity->getLinkTarget() ? LinkTarget::tryFrom($entity->getLinkTarget()) : null,
            noFollow: $entity->isLinkNoFollow(),
        );
    }
}
