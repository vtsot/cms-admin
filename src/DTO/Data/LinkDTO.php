<?php

declare(strict_types=1);

namespace App\DTO\Data;

use App\Contract\Dictionary\Link\LinkTarget;
use App\Contract\Dictionary\Link\LinkType;
use App\DTOFactory\Data\LinkDTOFactory;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * @see LinkDTOFactory
 */
readonly class LinkDTO
{
    public function __construct(
        #[Groups(['link_collection', 'link_details'])]
        public ?string $url = null,

        #[Groups(['link_collection', 'link_details'])]
        public ?string $slug = null,

        #[Groups(['link_collection', 'link_details'])]
        public ?LinkType $type = LinkType::Page,

        #[Groups(['link_collection', 'link_details'])]
        public ?LinkTarget $target = LinkTarget::Top,

        #[Groups(['link_collection', 'link_details'])]
        public ?bool $noFollow = false,
    ) {
    }
}
