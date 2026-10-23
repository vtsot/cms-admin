<?php

declare(strict_types=1);

namespace App\DTO\Entity\Page;

use App\DTOFactory\Entity\Page\PageDTOFactory;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\Uuid;

/**
 * @see PageDTOFactory
 */
readonly class PageDTO
{
    public function __construct(
        #[Groups(['page_collection', 'page_details'])]
        #[OA\Property(type: 'string', format: 'uuid')]
        public Uuid $id,

        #[Groups(['page_collection', 'page_details'])]
        public ?string $slug,

        #[Groups(['page_collection', 'page_details'])]
        public ?bool $isHomepage,

        #[Groups(['page_collection', 'page_details'])]
        public ?string $title,

        #[Groups(['page_collection', 'page_details'])]
        public ?string $content,

        #[Groups(['page_collection', 'page_details'])]
        public ?string $relatedArticlesTitle,

        #[Groups(['page_collection', 'page_details'])]
        #[OA\Property(type: 'array', items: new OA\Items(
            ref: new Model(type: ArticleDTO::class,
                groups: ['article_collection', 'article_details']),
        ))]
        /**
         * @var ArticleDTO[]
         */
        public ?array $relatedArticles = [],

        #[Groups(['page_collection', 'page_details'])]
        public ?string $sources,

        #[Groups(['page_collection', 'page_details'])]
        public ?string $redirect,

        #[Groups(['page_collection', 'page_details'])]
        public ?string $codeBlock,

        #[Groups(['page_collection', 'page_details'])]
        public ?string $metaTitle,

        #[Groups(['page_collection', 'page_details'])]
        public ?string $metaKeywords,

        #[Groups(['page_collection', 'page_details'])]
        public ?string $metaDescription,

        #[Groups(['page_collection', 'page_details'])]
        public ?string $ogTitle,

        #[Groups(['page_collection', 'page_details'])]
        public ?string $ogDescription,

        #[Groups(['page_collection', 'page_details'])]
        public ?string $ogImage,

        #[Groups(['page_collection', 'page_details'])]
        public ?bool $indexed,

        #[Groups(['page_collection', 'page_details'])]
        public ?string $sitemapChangeFrequency = 'weekly',

        #[Groups(['page_collection', 'page_details'])]
        public ?float $sitemapPriority = 0.5,
    ) {
    }
}
