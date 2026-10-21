<?php

declare(strict_types=1);

namespace App\DTO\Collection\Faq;

use App\DTO\Entity\Faq\FaqGroupDTO;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Groups;

readonly class FaqGroupCollectionDTO
{
    public function __construct(
        /** @var FaqGroupDTO[] */
        #[Groups(['faq_group_collection'])]
        #[OA\Property(
            type: 'array',
            items: new OA\Items(
                ref: new Model(
                    type: FaqGroupDTO::class,
                    groups: ['faq_group_collection'],
                )),
        )]
        public array $items,
    ) {
    }
}
