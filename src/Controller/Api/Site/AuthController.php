<?php

declare(strict_types=1);

namespace App\Controller\Api\Site;

use App\Contract\Dictionary\ApiDocTag;
use OpenApi\Attributes as OA;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route(host: '%api_domain%')]
class AuthController extends AbstractController
{
    #[Route(
        path: '/sites/auth/login',
        name: 'api.site.auth.login',
        requirements: ['id' => Requirement::UUID],
        options: ['expose' => true],
        methods: ['POST']
    )]
    #[OA\Parameter(ref: '#/components/parameters/accept_language')]
    #[OA\RequestBody(
        request: 'body',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'username', type: 'string', format: 'email'),
                new OA\Property(property: 'password', type: 'string'),
            ],
            type: 'object',
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns login and refresh tokens',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'token', type: 'string'),
                new OA\Property(property: 'refresh_token', type: 'string'),
                new OA\Property(property: 'refresh_token_expiration', type: 'number'),
            ],
            type: 'object',
        )
    )]
    #[OA\Response(ref: '#/components/responses/invalid_json', response: '400')]
    #[OA\Response(ref: '#/components/responses/invalid_credentials', response: '401')]
    #[OA\Tag(name: ApiDocTag::AUTH)]
    public function login(): void
    {
        throw new RuntimeException('Should be handled by security component');
    }

    //    #[Route(
    //        path: '/refresh-token',
    //        name: 'api.auth.refresh_token',
    //        options: ['expose' => true],
    //        methods: ['POST']
    //    )]
    //    #[OA\Parameter(ref: '#/components/parameters/accept_language')]
    //    #[OA\RequestBody(
    //        request: 'body',
    //        content: new OA\JsonContent(
    //            properties: [
    //                new OA\Property(property: 'refresh_token', type: 'string'),
    //            ],
    //            type: 'object',
    //        )
    //    )]
    //    #[OA\Response(
    //        response: 200,
    //        description: 'Returns login and refresh tokens',
    //        content: new OA\JsonContent(
    //            properties: [
    //                new OA\Property(property: 'token', type: 'string'),
    //                new OA\Property(property: 'refresh_token', type: 'string'),
    //            ],
    //            type: 'object',
    //        )
    //    )]
    //    #[OA\Response(ref: '#/components/responses/invalid_json', response: '400')]
    //    #[OA\Response(ref: '#/components/responses/invalid_credentials', response: '401')]
    //    #[OA\Tag(name: ApiDocTag::AUTH)]
    //    public function refreshToken(): void
    //    {
    //        throw new RuntimeException('Should be handled by security component');
    //    }
}
