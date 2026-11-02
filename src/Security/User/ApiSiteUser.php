<?php

declare(strict_types=1);

namespace App\Security\User;

use App\Contract\Dictionary\User\UserRole;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;

use function array_unique;

final readonly class ApiSiteUser implements JWTUserInterface
{
    public function __construct(
        public string $userIdentifier,
        public string $siteId,
        public string $token,
        public array $roles,
    ) {
    }

    public static function createFromPayload($username, array $payload): self|JWTUserInterface
    {
        $roles   = $payload['roles'] ?? [];
        $roles[] = UserRole::ApiSite->value;
        $roles   = array_unique($roles);

        return new self($username, $payload['siteId'] ?? '', $payload['token'] ?? '', $roles);
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getUserIdentifier(): string
    {
        return $this->userIdentifier;
    }
}
