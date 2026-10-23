<?php

declare(strict_types=1);

namespace App\Controller\Api\Site;

use App\Contract\Dictionary\ApiDocTag;
use App\CQ\Query\Site\Page\GetSitemapCollectionQuery;
use App\DTO\Collection\SitemapCollectionDTO;
use App\Security\User\ApiSiteUser;
use App\Service\MessageBusHandler;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Uid\Uuid;

class GetSitemapController extends AbstractController
{
    #[Route(
        path: '/api/sites/{id}/sitemap',
        name: 'api.site.sitemap.collection',
        requirements: ['id' => Requirement::UUID, 'slug' => Requirement::ASCII_SLUG],
        options: ['expose' => true],
        methods: ['GET']
    )]
    #[OA\Parameter(ref: '#/components/parameters/accept_language')]
    #[OA\Response(ref: '#/components/responses/error', response: Response::HTTP_UNPROCESSABLE_ENTITY)]
    #[OA\Response(ref: '#/components/responses/invalid_json', response: Response::HTTP_BAD_REQUEST)]
    #[OA\Response(ref: '#/components/responses/invalid_credentials', response: Response::HTTP_UNAUTHORIZED)]
    #[OA\Response(ref: '#/components/responses/forbidden', response: Response::HTTP_FORBIDDEN)]
    #[OA\Response(ref: '#/components/responses/not_found', response: Response::HTTP_NOT_FOUND)]
    #[OA\Response(
        response: 200,
        description: 'Return sitemap page collection',
        content: new OA\JsonContent(
            ref: new Model(
                type: SitemapCollectionDTO::class,
                groups: ['sitemap_collection'],
            )
        )
    )]
    #[OA\Tag(name: ApiDocTag::SITES)]
    public function getSitemapPageCollection(
        Uuid $id,
        MessageBusHandler $messageBusHandler,
        #[CurrentUser] ApiSiteUser $user,
    ): JsonResponse {
        /** @var SitemapCollectionDTO $dto */
        $dto = $messageBusHandler->handleQuery(
            new GetSitemapCollectionQuery(
                siteId: $id,
                token: $user->token,
            )
        );

        return $this->json(
            data: $dto,
            context: ['groups' => ['sitemap_collection']]
        );
    }
}
