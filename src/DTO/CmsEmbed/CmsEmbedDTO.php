<?php

declare(strict_types=1);

namespace App\DTO\CmsEmbed;

use App\DTOFactory\CmsEmbed\CmsEmbedDTOFactory;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * @see CmsEmbedDTOFactory
 */
readonly class CmsEmbedDTO
{
    public function __construct(
        #[Groups([
            'cms_embed_collection',
            'cms_embed_details',
        ])]
        public string $id,
        #[Groups([
            'cms_embed_collection',
            'cms_embed_details',
        ])]
        public string $label,
        #[Groups([
            'cms_embed_collection',
            'cms_embed_details',
        ])]
        public string $help,
        #[Groups([
            'cms_embed_collection',
            'cms_embed_details',
        ])]
        public string $placeholder,
        #[OA\Property(type: 'array', items: new OA\Items(type: 'string'))]
        #[Groups([
            'cms_embed_collection',
            'cms_embed_details',
        ])]
        public array $params,
    ) {
    }
}
