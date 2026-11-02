<?php

declare(strict_types=1);

namespace App\Security\ApiSite;

use App\Exception\Security\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\AccessToken\AccessTokenExtractorInterface;
use Symfony\Component\Security\Http\AccessToken\HeaderAccessTokenExtractor;

use function is_string;
use function preg_match;
use function preg_quote;
use function sprintf;

/**
 * @deprecated
 * @see HeaderAccessTokenExtractor
 */
class AccessTokenExtractor implements AccessTokenExtractorInterface
{
    private string $regex;

    public function __construct(
        private readonly string $headerParameter = 'Authorization',
        private readonly string $tokenType = 'Bearer',
    ) {
        $this->regex = sprintf(
            '/^%s([a-zA-Z0-9\-_\+~\/\.]+)$/',
            preg_quote($this->tokenType, null) . '\s+'
        );
    }

    public function extractAccessToken(Request $request): string
    {
        if (!$request->headers->has($this->headerParameter)
            || !is_string($header = $request->headers->get($this->headerParameter))
        ) {
            throw new AccessDeniedException('Authentication Required');
        }

        // resolve token from header
        if (preg_match($this->regex, $header, $matches)) {
            return $matches[1];
        }

        throw new AccessDeniedException('No API Token Provided');
    }
}
