<?php

declare(strict_types=1);

namespace App\DTO\Entity\Page;

use App\Contract\Dictionary\PageType;
use App\DTOFactory\Entity\Page\ArticleInfoDTOFactory;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\Uuid;

/**
 * @see ArticleInfoDTOFactory
 */
readonly class ArticleInfoDTO
{
    public function __construct(
        #[Groups(['article_collection', 'article_info'])]
        #[OA\Property(type: 'string', format: 'uuid')]
        public Uuid $id,

        #[Groups(['article_collection', 'article_info'])]
        public string $slug,

        #[Groups(['article_collection', 'article_info'])]
        public ?string $title,

        #[Groups(['article_collection', 'article_info'])]
        #[OA\Property(type: 'string')]
        public ?PageType $type,

        #[Groups(['article_collection', 'article_info'])]
        public ?string $imageAlt,

        #[Groups(['article_collection', 'article_info'])]
        public ?string $image,

        #[Groups(['article_collection', 'article_info'])]
        public ?string $description,

        #[Groups(['article_collection', 'article_info'])]
        public ?string $content,

        #[Groups(['article_collection', 'article_info'])]
        public ?string $sources,
    ) {
    }
}
