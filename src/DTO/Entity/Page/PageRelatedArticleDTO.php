<?php

declare(strict_types=1);

namespace App\DTO\Entity\Page;

use App\DTOFactory\Entity\Page\PageRelatedArticleDTOFactory;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

/**
 * @see PageRelatedArticleDTOFactory
 */
readonly class PageRelatedArticleDTO
{
    public function __construct(
        #[Groups(['page_related_article_collection', 'page_related_article_details'])]
        #[OA\Property(type: 'string', format: 'uuid')]
        public Uuid $id,

        #[Groups(['page_related_article_collection', 'page_related_article_details'])]
        public ArticleDTO $article,
    ) {
    }
}
