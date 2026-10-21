<?php

declare(strict_types=1);

namespace App\DTO\Data;

use Symfony\Component\Serializer\Annotation\Groups;

class RandomItemDTO
{
    public function __construct(
        #[Groups(['random_collection', 'random_details'])]
        public mixed $identifier,

        #[Groups(['random_collection', 'random_details'])]
        public int $priority,
    ) {
    }
}
