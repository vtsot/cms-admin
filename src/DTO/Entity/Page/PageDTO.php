<?php

declare(strict_types=1);

namespace App\DTO\Entity\Page;

use App\DTOFactory\Entity\Page\PageDTOFactory;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Groups;
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
        public ?string $slug = null,

        #[Groups(['page_collection', 'page_details'])]
        public ?bool $isHomepage = false,

        #[Groups(['page_collection', 'page_details'])]
        public ?string $title = null,

        #[Groups(['page_collection', 'page_details'])]
        public ?string $content = null,

        #[Groups(['page_collection', 'page_details'])]
        public ?string $relatedArticlesTitle = null,

        #[Groups(['page_collection', 'page_details'])]
        public ?string $sources = null,

        #[Groups(['page_collection', 'page_details'])]
        public ?string $redirect = null,

        #[Groups(['page_collection', 'page_details'])]
        public ?string $codeBlock = null,

        #[Groups(['page_collection', 'page_details'])]
        public ?string $metaTitle = null,

        #[Groups(['page_collection', 'page_details'])]
        public ?string $metaKeywords = null,

        #[Groups(['page_collection', 'page_details'])]
        public ?string $metaDescription = null,

        #[Groups(['page_collection', 'page_details'])]
        public ?string $ogTitle = null,

        #[Groups(['page_collection', 'page_details'])]
        public ?string $ogDescription = null,

        #[Groups(['page_collection', 'page_details'])]
        public ?string $ogImage = null,

        #[Groups(['page_collection', 'page_details'])]
        public bool $indexed = true,

        #[Groups(['page_collection', 'page_details'])]
        public ?string $sitemapChangeFrequency = 'weekly',

        #[Groups(['page_collection', 'page_details'])]
        public ?float $sitemapPriority = 0.5,

        #[Groups(['page_collection', 'page_details'])]
        #[OA\Property(type: 'array', items: new OA\Items(
            ref: new Model(type: PageRelatedArticleDTO::class, groups: [
                'page_related_article_collection', 'article_collection',
            ]),
        ))]
        /**
         * @var ArticleDTO[]
         */
        public ?array $relatedArticles = [],
    ) {
    }
}
