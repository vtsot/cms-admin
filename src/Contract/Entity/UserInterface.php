<?php

declare(strict_types=1);

namespace App\Contract\Entity;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface as BaseUserInterface;

interface UserInterface extends EntityInterface, PasswordAuthenticatedUserInterface, BaseUserInterface
{
    public function setPlainPassword(string $password): static;

    public function getPlainPassword(): ?string;

    public function setPassword(string $password): static;

    public function setRoles(array $roles): static;

    public function hasRole(string $role): bool;

    public function isActive(): bool;

    public function setActive(bool $active): static;

    public function isGoogleAuthenticatorEnabled(): bool;

    public function getGoogleAuthenticatorToken(): ?string;

    public function setGoogleAuthenticatorToken(?string $googleAuthenticatorToken);

    public function isEmailConfirmed(): bool;
}
