<?php

declare(strict_types=1);

namespace App\Security\UserProvider;

use App\Repository\Site\SiteSettingsRepository;
use App\Security\User\ApiSiteUser;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\PayloadAwareUserProviderInterface;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

class ApiSiteTokenUserProvider implements PayloadAwareUserProviderInterface
{
    private string $class = ApiSiteUser::class;

    private array $cache = [];

    public function __construct(
        private readonly SiteSettingsRepository $siteSettingsRepository,
    ) {
    }

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

        $payload[$class::CONTEXT_IS_API_LOG_ENABLED] = $this->resolveIsApiLogEnable($payload);

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

    private function resolveIsApiLogEnable(array $payload): bool
    {
        // get site settings by payload
        return ($payload['siteId'] ?? null) && Uuid::isValid($payload['siteId']) && ($payload['token'] ?? null)
            ? $this->siteSettingsRepository->findOneBySiteIdAndToken(Uuid::fromString($payload['siteId']), $payload['token'])->isApiLogEnabled()
            : false;
    }
}
