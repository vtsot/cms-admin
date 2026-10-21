<?php

declare(strict_types=1);

namespace App\DTO\Collection;

use App\DTO\Entity\Page\PageRelatedArticleDTO;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Groups;

readonly class PageRelatedArticleCollectionDTO
{
    public function __construct(
        /** @var PageRelatedArticleDTO[] */
        #[Groups(['page_related_article_collection'])]
        #[OA\Property(
            type: 'array',
            items: new OA\Items(
                ref: new Model(
                    type: PageRelatedArticleDTO::class,
                    groups: ['page_related_article_collection'],
                )),
        )]
        public array $items,
    ) {
    }
}
