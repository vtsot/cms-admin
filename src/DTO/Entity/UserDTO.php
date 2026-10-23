<?php

declare(strict_types=1);

namespace App\DTO\Entity;

use App\DTOFactory\Entity\UserDTOFactory;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\Uuid;

/**
 * @see UserDTOFactory
 */
readonly class UserDTO
{
    public function __construct(
        #[Groups(['user_collection', 'user_details'])]
        #[OA\Property(type: 'string', format: 'uuid')]
        public Uuid $id,

        #[Groups(['user_collection', 'user_details'])]
        public ?string $firstName,

        #[Groups(['user_collection', 'user_details'])]
        public ?string $lastName,

        #[Groups(['user_collection', 'user_details'])]
        public ?string $email,

        #[Groups(['user_collection', 'user_details'])]
        #[OA\Property(type: 'array', items: new OA\Items(type: 'string'))]
        public array $roles,
    ) {
    }
}
