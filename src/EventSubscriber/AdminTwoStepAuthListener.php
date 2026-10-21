<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Contract\Entity\UserInterface;
use Doctrine\ORM\EntityManagerInterface;
use Google\Authenticator\GoogleQrUrl;
use Sonata\GoogleAuthenticator\GoogleAuthenticator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Twig\Environment as Twig;

use function sprintf;
use function str_starts_with;

readonly class AdminTwoStepAuthListener implements EventSubscriberInterface
{
    private const ISSUER = 'rsm';

    public function __construct(
        private GoogleAuthenticator $authenticator,
        private TokenStorageInterface $tokenStorage,
        private Twig $twig,
        private EntityManagerInterface $em,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        if (!str_starts_with($event->getRequest()->getPathInfo(), '/admin')) {
            return;
        }

        $token = $this->tokenStorage->getToken();

        if (!$token instanceof TokenInterface) {
            return;
        }

        $user = $token?->getUser();

        if (!$user instanceof UserInterface) {
            return;
        }

        // GoogleAuthenticator is disabled
        if (!$user->isGoogleAuthenticatorEnabled()) {
            return;
        }

        // GoogleAuthenticator is enabled
        // process it
        $request    = $event->getRequest();
        $sessionKey = sprintf('_user_two_step_auth_%s_%s', $token->getFirewallName(), $token->getUserIdentifier());

        // google auth token is not set yet
        if ($user->getGoogleAuthenticatorToken() === null) {
            $event->setResponse($this->handleAuthResponse($request, $user, $sessionKey));

            return;
        }

        // google auth token was set
        // confirm the code
        if (!$request->getSession()->has($sessionKey)
            || $request->getSession()->get($sessionKey) !== true
        ) {
            $event->setResponse($this->handleConfirmResponse($request, $user, $sessionKey));
        }
    }

    private function handleAuthResponse(
        Request $request,
        UserInterface $user,
        string $sessionKey,
    ): Response {
        $session   = $request->getSession();
        $secretKey = $sessionKey . '_secret';

        if (!$session->has($secretKey)) {
            $session->set($secretKey, $this->authenticator->generateSecret());
        }

        $error  = false;
        $secret = $session->get($secretKey);

        // handle post request
        if ($request->isMethod(Request::METHOD_POST)) {
            if ($this->authenticator->checkCode($secret, $request->get('_code'))) {
                // update session
                $session->set($sessionKey, true);
                $session->remove($secretKey);

                // update user's $secret
                $user->setGoogleAuthenticatorToken($secret);
                $this->em->persist($user);
                $this->em->flush();

                return new RedirectResponse($request->getUri());
            }

            $error = true;
        }

        return new Response(
            $this->twig->render(
                'admin/security/google-authentication.html.twig',
                [
                    'validate'  => false,
                    'error'     => $error,
                    'qrCodeImg' => GoogleQrUrl::generate($user->getUserIdentifier(), $secret, self::ISSUER),
                ]
            )
        );
    }

    private function handleConfirmResponse(
        Request $request,
        UserInterface $user,
        string $sessionKey,
    ): Response {
        $session = $request->getSession();
        $error   = false;

        // handle post request
        if ($request->isMethod(Request::METHOD_POST)) {
            if ($this->authenticator->checkCode($user->getGoogleAuthenticatorToken(), $request->get('_code'))) {
                $session->set($sessionKey, true);

                return new RedirectResponse($request->getUri());
            }

            $error = true;
        }

        return new Response(
            $this->twig->render(
                'admin/security/google-authentication.html.twig',
                [
                    'validate' => true,
                    'error'    => $error,
                ]
            )
        );
    }
}
