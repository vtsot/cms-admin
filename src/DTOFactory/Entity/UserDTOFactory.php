<?php

declare(strict_types=1);

namespace App\DTOFactory\Entity;

use App\DTO\Entity\UserDTO;
use App\Entity\User;

readonly class UserDTOFactory
{
    public function fromEntity(User $user): UserDTO
    {
        return new UserDTO(
            $user->getId(),
            $user->getFirstName(),
            $user->getLastName(),
            $user->getEmail(),
            $user->getRoles()
        );
    }
}
