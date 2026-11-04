<?php

declare(strict_types=1);

namespace App\Security\User;

use App\Contract\Dictionary\User\UserRole;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;
use Symfony\Component\Uid\NilUuid;
use Symfony\Component\Uid\Uuid;

use function array_unique;

final readonly class ApiSiteUser implements JWTUserInterface
{
    public const string CONTEXT_IS_API_LOG_ENABLED = 'isApiLogEnabled';

    public function __construct(
        public string $userIdentifier,
        public Uuid $userId,
        public Uuid $siteId,
        public string $token,
        public array $roles,
        public bool $isApiLogEnabled = false,
    ) {
    }

    public static function createFromPayload($username, array $payload): self|JWTUserInterface
    {
        $roles   = $payload['roles'] ?? [];
        $roles[] = UserRole::ApiSite->value;
        $roles   = array_unique($roles);

        return new self(
            userIdentifier: $username,
            userId: Uuid::isValid($payload['userId']) ? Uuid::fromString($payload['userId']) : new NilUuid(),
            siteId: Uuid::isValid($payload['siteId']) ? Uuid::fromString($payload['siteId']) : new NilUuid(),
            token: $payload['token'] ?? '',
            roles: $roles,
            isApiLogEnabled: $payload[self::CONTEXT_IS_API_LOG_ENABLED] ?? false,
        );
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
