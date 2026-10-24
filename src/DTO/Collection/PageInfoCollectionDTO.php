<?php

declare(strict_types=1);

namespace App\DTO\Collection;

use App\DTO\Entity\Page\ArticleInfoDTO;
use App\DTO\Entity\Page\PageInfoDTO;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Attribute\Groups;

final readonly class PageInfoCollectionDTO extends AbstractCollectionDTO
{
    /** @var PageInfoDTO[]|ArticleInfoDTO[] */
    #[Groups(['page_collection', 'page_info', 'article_collection', 'article_info'])]
    #[OA\Property(
        type: 'array',
        items: new OA\Items(
            oneOf: [
                new OA\Schema(ref: new Model(
                    type: PageInfoDTO::class,
                    groups: ['page_collection', 'page_info'],
                )),
                new OA\Schema(ref: new Model(
                    type: ArticleInfoDTO::class,
                    groups: ['article_collection', 'article_info'],
                )),
            ]
        )
    )]
    public array $items;
}
