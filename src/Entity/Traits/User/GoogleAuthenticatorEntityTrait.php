<?php

declare(strict_types=1);

namespace App\Entity\Traits\User;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait GoogleAuthenticatorEntityTrait
{
    #[ORM\Column(name: 'is_google_authenticator_enabled', type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    private bool $googleAuthenticatorEnabled = false;

    #[ORM\Column(name: 'google_authenticator_token', type: Types::STRING, length: 255, nullable: true)]
    private ?string $googleAuthenticatorToken = null;

    public function isGoogleAuthenticatorEnabled(): bool
    {
        return $this->googleAuthenticatorEnabled;
    }

    public function setGoogleAuthenticatorEnabled(bool $googleAuthenticatorEnabled): static
    {
        $this->googleAuthenticatorEnabled = $googleAuthenticatorEnabled;

        return $this;
    }

    public function getGoogleAuthenticatorToken(): ?string
    {
        return $this->googleAuthenticatorToken;
    }

    public function setGoogleAuthenticatorToken(?string $googleAuthenticatorToken): static
    {
        $this->googleAuthenticatorToken = $googleAuthenticatorToken;

        return $this;
    }
}
