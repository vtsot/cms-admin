<?php

declare(strict_types=1);

namespace App\Security\User;

use Deprecated;
use Symfony\Component\Security\Core\User\UserInterface;

final readonly class ApiSiteUser implements UserInterface
{
    public function __construct(
        public string $token,
        public array $roles,
    ) {
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    #[Deprecated]
    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->token;
    }
}
