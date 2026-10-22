<?php

declare(strict_types=1);

namespace App\DTOFactory\Entity\Navigation;

use App\Contract\Entity\LinkEntityInterface;
use App\DTO\Entity\NavigationDTO;
use App\DTOFactory\Data\LinkDTOFactory;
use App\DTOFactory\Entity\Uuid;
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
        $id = $navigation->getId() ?? Uuid::fromString(Uuid::NIL);

        return new NavigationDTO(
            $id,
            $navigation->getTitle(),
            $this->linkDTOFactory->fromEntity($navigation),
            $children,
        );
    }
}
