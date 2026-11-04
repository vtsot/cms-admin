<?php

declare(strict_types=1);

namespace App\DTO\Collection;

use App\DTO\Entity\Page\ArticleInfoDTO;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Attribute\Groups;

final readonly class ArticleInfoCollectionDTO extends AbstractCollectionDTO
{
    /** @var ArticleInfoDTO[] */
    #[Groups(['article_collection', 'article_info'])]
    #[OA\Property(
        type: 'array',
        items: new OA\Items(
            ref: new Model(
                type: ArticleInfoDTO::class,
                groups: ['article_collection', 'article_info'],
            )),
    )]
    public array $items;
}
