<?php

declare(strict_types=1);

namespace App\Entity\Traits\User;

use App\Contract\Dictionary\User\UserRole;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use function in_array;

trait UserRolesEntityTrait
{
    #[ORM\Column(name: 'roles', type: Types::JSON, nullable: false)]
    private array $roles = [UserRole::User->value];

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function hasRole(string $role): bool
    {
        return in_array($role, $this->getRoles(), true);
    }
}
