<?php

declare(strict_types=1);

namespace App\DTOFactory\Entity;

use App\DTO\Entity\UserDTO;
use App\Entity\User;
use Ramsey\Uuid\Uuid;

readonly class UserDTOFactory
{
    public function fromEntity(User $user): UserDTO
    {
        $id = $user->getId() ?? Uuid::fromString(Uuid::NIL);

        return new UserDTO(
            $id,
            $user->getFirstName(),
            $user->getLastName(),
            $user->getEmail(),
            $user->getRoles()
        );
    }
}
