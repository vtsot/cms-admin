<?php

declare(strict_types=1);

namespace App\DTO\Entity\Page;

use App\DTOFactory\Entity\Page\PageDetailsDTOFactory;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\Uuid;

/**
 * @see PageDetailsDTOFactory
 */
readonly class PageDetailsDTO
{
    public function __construct(
        #[Groups(['page_details'])]
        #[OA\Property(type: 'string', format: 'uuid')]
        public Uuid $id,

        #[Groups(['page_details'])]
        public ?string $slug,

        #[Groups(['page_details'])]
        public ?bool $isHomepage,

        #[Groups(['page_details'])]
        public ?string $title,

        #[Groups(['page_details'])]
        public ?string $content,

        #[Groups(['page_details'])]
        public ?string $relatedArticlesTitle,

        #[Groups(['page_details'])]
        #[OA\Property(type: 'array',
            items: new OA\Items(
                ref: new Model(
                    type: ArticleDetailsDTO::class,
                    groups: ['article_details']),
            ))]
        /**
         * @var ArticleDetailsDTO[]
         */
        public ?array $relatedArticles = [],

        #[Groups(['page_details'])]
        public ?string $sources,

        #[Groups(['page_details'])]
        public ?string $redirect,

        #[Groups(['page_details'])]
        public ?string $codeBlock,

        #[Groups(['page_details'])]
        public ?string $metaTitle,

        #[Groups(['page_details'])]
        public ?string $metaKeywords,

        #[Groups(['page_details'])]
        public ?string $metaDescription,

        #[Groups(['page_details'])]
        public ?string $ogTitle,

        #[Groups(['page_details'])]
        public ?string $ogDescription,

        #[Groups(['page_details'])]
        public ?string $ogImage,

        #[Groups(['page_details'])]
        public ?bool $indexed,

        #[Groups(['page_details'])]
        public ?string $sitemapChangeFrequency = 'weekly',

        #[Groups(['page_details'])]
        public ?float $sitemapPriority = 0.5,
    ) {
    }
}
