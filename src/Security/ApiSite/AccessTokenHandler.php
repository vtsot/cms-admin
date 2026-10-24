<?php

declare(strict_types=1);

namespace App\Security\ApiSite;

use App\Exception\Security\AccessDeniedException;
use App\Repository\Site\SiteRepository;
use SensitiveParameter;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

readonly class AccessTokenHandler implements AccessTokenHandlerInterface
{
    public function __construct(
        private SiteRepository $siteRepository,
    ) {
    }

    public function getUserBadgeFrom(#[SensitiveParameter] string $accessToken): UserBadge
    {
        $site = $this->siteRepository->findOneByToken($accessToken);

        if (!$site) {
            throw new AccessDeniedException('Undefined API Token Provided');
        }

        if (!$site->isActive()) {
            throw new AccessDeniedException('Inactive API Token Provided');
        }

        return new UserBadge($site->getToken());
    }
}
