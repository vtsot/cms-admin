<?php

declare(strict_types=1);

namespace App\Security\UserProvider;

use App\Security\User\ApiSiteUser;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\PayloadAwareUserProviderInterface;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\Security\Core\User\UserInterface;

class ApiSiteTokenUserProvider implements PayloadAwareUserProviderInterface
{
    private string $class = ApiSiteUser::class;

    private array $cache = [];

    public function loadUserByIdentifier(string $identifier, array $payload = []): UserInterface
    {
        return $this->loadUserByIdentifierAndPayload($identifier, $payload);
    }

    public function loadUserByIdentifierAndPayload(string $identifier, array $payload): UserInterface
    {
        if (isset($this->cache[$identifier])) {
            return $this->cache[$identifier];
        }

        $class = $this->class;

        return $this->cache[$identifier] = $class::createFromPayload($identifier, $payload);
    }

    /**
     * @throws ReflectionException
     */
    public function supportsClass($class): bool
    {
        return $class === $this->class || new ReflectionClass($class)->implementsInterface(JWTUserInterface::class);
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        return $user; // noop
    }
}
