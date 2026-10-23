<?php

declare(strict_types=1);

namespace App\DTOFactory\Entity\Navigation;

use App\Contract\Entity\LinkEntityInterface;
use App\DTO\Entity\NavigationDTO;
use App\DTOFactory\Data\LinkDTOFactory;
use App\Entity\Navigation\AbstractNavigation;

readonly class NavigationDTOFactory
{
    public function __construct(
        private LinkDTOFactory $linkDTOFactory,
    ) {
    }

    public function fromEntity(
        AbstractNavigation|LinkEntityInterface $navigation,
        ?array $children = [],
    ): NavigationDTO {
        return new NavigationDTO(
            $navigation->getId(),
            $navigation->getTitle(),
            $this->linkDTOFactory->fromEntity($navigation),
            $children,
        );
    }
}
