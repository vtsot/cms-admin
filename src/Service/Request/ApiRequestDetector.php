<?php

declare(strict_types=1);

namespace App\Service\Request;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;

use function in_array;
use function str_contains;

readonly class ApiRequestDetector
{
    public function __construct(
        #[Autowire(param: 'api_domain')]
        private string $apiDomain,
    ) {
    }

    public function isApiRequest(Request $request): bool
    {
        return $request->isXmlHttpRequest()
            || $request->getContentTypeFormat() === 'json'
            || $request->getHost() === $this->apiDomain
            || in_array('application/json', $request->getAcceptableContentTypes(), true)
            || str_contains($request->getPathInfo(), '/api/');
    }
}
