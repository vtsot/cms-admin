<?php

declare(strict_types=1);

namespace App\DTO\Collection\Faq;

use App\DTO\Entity\Faq\FaqDTO;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Groups;

readonly class FaqCollectionDTO
{
    public function __construct(
        /** @var FaqDTO[] */
        #[Groups(['faq_collection'])]
        #[OA\Property(
            type: 'array',
            items: new OA\Items(
                ref: new Model(
                    type: FaqDTO::class,
                    groups: ['faq_collection'],
                )),
        )]
        public array $items,
    ) {
    }
}
