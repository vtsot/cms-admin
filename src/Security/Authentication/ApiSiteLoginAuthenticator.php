<?php

declare(strict_types=1);

namespace App\Security\Authentication;

use App\Contract\Dictionary\User\UserRole;
use App\Exception\AppException;
use App\Exception\Security\AccessDeniedException;
use App\Exception\Validation\BadRequestException;
use App\Exception\Validation\EntityNotFoundException;
use App\Repository\Site\SiteRepository;
use App\Security\UserProvider\RegularUserProvider;
use App\Service\Request\ApiRequestDetector;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\InvalidTokenException;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationFailureHandler as LexikFailureHandler;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler as LexikSuccessHandler;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Translation\TranslatorInterface;

use function str_contains;

class ApiSiteLoginAuthenticator extends AbstractAuthenticator
{
    public const string HEADER_SITE_ID    = 'X-Site-Id';
    public const string HEADER_SITE_TOKEN = 'X-Site-Token';

    public function __construct(
        private readonly TranslatorInterface $translator,
        private readonly JWTTokenManagerInterface $jwtManager,
        private readonly ApiRequestDetector $apiRequestDetector,
        private readonly RegularUserProvider $userProvider,
        private readonly SiteRepository $siteRepository,
        private readonly AuthorizationCheckerInterface $authorizationChecker,

        #[Autowire(service: 'lexik_jwt_authentication.handler.authentication_failure')]
        private readonly LexikFailureHandler $jwtFailureHandler,

        #[Autowire(service: 'lexik_jwt_authentication.handler.authentication_success')]
        private readonly LexikSuccessHandler $jwtSuccessHandler,
    ) {
    }

    public function supports(Request $request): ?bool
    {
        return $this->apiRequestDetector->isApiRequest($request)
            && str_contains($request->getPathInfo(), '/sites/auth/');
    }

    public function authenticate(Request $request): Passport
    {
        $idClaim           = $this->jwtManager->getUserIdClaim();
        $payload[$idClaim] = $request->request->get($idClaim);

        try {
            if (!$siteId = $request->headers->get(self::HEADER_SITE_ID)) {
                throw new BadRequestException($this->translator->trans(
                    id: 'SECURITY.HEADER_REQUIRED',
                    parameters: ['%HEADER%' => self::HEADER_SITE_ID],
                    domain: 'security',
                ));
            }

            if (!Uuid::isValid($siteId)) {
                throw new BadRequestException(
                    $this->translator->trans(
                        id: 'SECURITY.HEADER_INVALID',
                        parameters: ['%HEADER%' => self::HEADER_SITE_ID],
                        domain: 'security'
                    )
                );
            }

            if (!$token = $request->headers->get(self::HEADER_SITE_TOKEN)) {
                throw new BadRequestException(
                    $this->translator->trans(
                        id: 'SECURITY.HEADER_REQUIRED',
                        parameters: ['%HEADER%' => self::HEADER_SITE_TOKEN],
                        domain: 'security'
                    )
                );
            }

            // check the site exists
            if (!$this->siteRepository->findOneActiveBySiteIdAndToken(Uuid::fromString($siteId), $token)) {
                throw new EntityNotFoundException(
                    $this->translator->trans(
                        id: 'SECURITY.SITE_NOT_FOUND',
                        parameters: ['%SITE%' => $siteId, '%TOKEN%' => $token],
                        domain: 'security'
                    )
                );
            }

            // user is admin
            $isAdmin = ($user = $this->userProvider->loadUserByIdentifier($payload[$idClaim]))
                && ($user->hasRole(UserRole::Admin->value) || $user->hasRole(UserRole::Supervisor->value));

            // when the user is not admin
            if (!$isAdmin
                // check the client belong to the site
                && !$this->siteRepository
                    ->findOneActiveBySiteIdAndTokenAndClientIdentifier(Uuid::fromString($siteId), $token, $payload[$idClaim])
            ) {
                throw new AccessDeniedException(
                    $this->translator->trans(
                        id: 'SECURITY.ACCESS_DENIED',
                        domain: 'security'
                    )
                );
            }
        } catch (BadRequestException|EntityNotFoundException|AccessDeniedException $e) {
            throw $e;
        } catch (AppException $e) {
            throw new InvalidTokenException($e->getMessage(), 0, $e);
        }

        // create passport
        $passport = new Passport(
            new UserBadge(
                (string) $payload[$idClaim],
                fn ($userIdentifier) => $this->userProvider->loadUserByIdentifier($userIdentifier),
            ),
            new PasswordCredentials($request->request->getString('password'))
        );

        $passport->setAttribute('payload', $payload);

        return $passport;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return $this->jwtFailureHandler->onAuthenticationFailure($request, $exception);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return $this->jwtSuccessHandler->onAuthenticationSuccess($request, $token);
    }
}
