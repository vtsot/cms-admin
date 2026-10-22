<?php

declare(strict_types=1);

namespace App\DTO\Entity\Page;

use App\DTOFactory\Entity\Page\ArticleDTOFactory;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

/**
 * @see ArticleDTOFactory
 */
readonly class ArticleDTO
{
    public function __construct(
        #[Groups(['article_collection', 'article_details'])]
        #[OA\Property(type: 'string', format: 'uuid')]
        public Uuid $id,

        #[Groups(['article_collection', 'article_details'])]
        public string $slug,

        #[Groups(['article_collection', 'article_details'])]
        public ?string $title = null,

        #[Groups(['article_collection', 'article_details'])]
        public ?string $alt = null,

        #[Groups(['article_collection', 'article_details'])]
        public ?string $image = null,

        #[Groups(['article_collection', 'article_details'])]
        public ?string $description = null,
    ) {
    }
}
