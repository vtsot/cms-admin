<?php

declare(strict_types=1);

namespace App\Security\RateLimiter;

use Symfony\Component\HttpFoundation\RateLimiter\PeekableRequestRateLimiterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\RateLimiter\Policy\NoLimiter;
use Symfony\Component\RateLimiter\RateLimit;

/**
 * Limits only the login route of the api_site firewall.
 *
 * login_throttling runs for every authenticator of a firewall, so without this check
 * invalid or expired JWTs would use up the IP limit and block valid JWTs from that IP.
 */
readonly class ApiSiteLoginRateLimiter implements PeekableRequestRateLimiterInterface
{
    private const string LOGIN_ROUTE = 'api.site.auth.login';

    public function __construct(
        private PeekableRequestRateLimiterInterface $limiter,
    ) {
    }

    public function consume(Request $request): RateLimit
    {
        return $this->isLogin($request) ? $this->limiter->consume($request) : new NoLimiter()->consume(1);
    }

    public function peek(Request $request): RateLimit
    {
        return $this->isLogin($request) ? $this->limiter->peek($request) : new NoLimiter()->consume(0);
    }

    public function reset(Request $request): void
    {
        if ($this->isLogin($request)) {
            $this->limiter->reset($request);
        }
    }

    private function isLogin(Request $request): bool
    {
        return $request->attributes->get('_route') === self::LOGIN_ROUTE;
    }
}
