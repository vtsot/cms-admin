<?php

declare(strict_types=1);

namespace App\DTO\Entity\Page;

use App\DTOFactory\Entity\Page\ArticleDetailsDTOFactory;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\Uuid;

/**
 * @see ArticleDetailsDTOFactory
 */
readonly class ArticleDetailsDTO
{
    public function __construct(
        #[Groups(['article_details'])]
        #[OA\Property(type: 'string', format: 'uuid')]
        public Uuid $id,

        #[Groups(['article_details'])]
        public string $slug,

        #[Groups(['article_details'])]
        public ?string $title,

        #[Groups(['article_details'])]
        public ?string $imageAlt,

        #[Groups(['article_details'])]
        public ?string $image,

        #[Groups(['article_details'])]
        public ?string $description,

        #[Groups(['article_details'])]
        public ?string $content,

        #[Groups(['article_details'])]
        public ?string $sources,

        #[Groups(['article_details'])]
        public ?string $redirect,

        #[Groups(['article_details'])]
        public ?string $codeBlock,

        #[Groups(['article_details'])]
        public ?string $metaTitle,

        #[Groups(['article_details'])]
        public ?string $metaKeywords,

        #[Groups(['article_details'])]
        public ?string $metaDescription,

        #[Groups(['article_details'])]
        public ?string $ogTitle,

        #[Groups(['article_details'])]
        public ?string $ogDescription,

        #[Groups(['article_details'])]
        public ?string $ogImage,

        #[Groups(['article_details'])]
        public ?bool $indexed,

        #[Groups(['article_details'])]
        public ?string $sitemapChangeFrequency = 'weekly',

        #[Groups(['article_details'])]
        public ?float $sitemapPriority = 0.5,
    ) {
    }
}
