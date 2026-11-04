<?php

declare(strict_types=1);

namespace App\DTO\Entity\Page;

use App\Contract\Dictionary\PageType;
use App\DTOFactory\Entity\Page\PageInfoDTOFactory;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\Uuid;

/**
 * @see PageInfoDTOFactory
 */
readonly class PageInfoDTO
{
    public function __construct(
        #[Groups(['page_collection', 'page_info'])]
        #[OA\Property(type: 'string', format: 'uuid')]
        public Uuid $id,

        #[Groups(['page_collection', 'page_info'])]
        public ?string $slug,

        #[Groups(['page_collection', 'page_info'])]
        public PageType $type,

        #[Groups(['page_collection', 'page_info'])]
        public ?bool $isHomepage,

        #[Groups(['page_collection', 'page_info'])]
        public ?string $title,

        #[Groups(['page_collection', 'page_info'])]
        public ?string $content,

        #[Groups(['page_collection', 'page_info'])]
        public ?string $sources,
    ) {
    }
}
