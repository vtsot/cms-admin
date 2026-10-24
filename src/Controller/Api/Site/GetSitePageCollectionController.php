<?php

declare(strict_types=1);

namespace App\Controller\Api\Site;

use App\Contract\Dictionary\ApiDocTag;
use App\Contract\Dictionary\PageType;
use App\ControllerRequest\Api\Site\GetSitePageCollectionRequest;
use App\CQ\Query\Site\Page\GetSitePageCollectionQuery;
use App\DTO\Collection\PageInfoCollectionDTO;
use App\DTOFactory\Collection\PageCriteriaDTOFactory;
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

#[Route(host: '%api_domain%')]
class GetSitePageCollectionController extends AbstractController
{
    #[Route(
        path: '/sites/{id}/pages',
        name: 'api.site.page.collection',
        requirements: ['id' => Requirement::UUID],
        options: ['expose' => true],
        methods: ['GET']
    )]
    #[OA\Parameter(ref: '#/components/parameters/accept_language')]
    #[OA\Response(ref: '#/components/responses/error', response: Response::HTTP_UNPROCESSABLE_ENTITY)]
    #[OA\Response(ref: '#/components/responses/invalid_json', response: Response::HTTP_BAD_REQUEST)]
    #[OA\Response(ref: '#/components/responses/invalid_credentials', response: Response::HTTP_UNAUTHORIZED)]
    #[OA\Response(ref: '#/components/responses/forbidden', response: Response::HTTP_FORBIDDEN)]
    #[OA\Response(ref: '#/components/responses/not_found', response: Response::HTTP_NOT_FOUND)]
    // custom
    #[OA\Parameter(ref: '#/components/parameters/page')]
    #[OA\Parameter(ref: '#/components/parameters/per_page')]
    #[OA\Parameter(ref: '#/components/parameters/query')]
    #[OA\Parameter(ref: '#/components/parameters/start_day')]
    #[OA\Parameter(ref: '#/components/parameters/end_day')]
    // #[OA\Parameter(ref: '#/components/parameters/sort')]
    #[OA\Parameter(
        name: 'sort',
        in: 'query',
        required: false,
        schema: new OA\Schema(
            type: 'string',
            default: 'created_at asc'
        ),
        examples: [
            new OA\Examples(example: 'created_at asc', summary: 'Sort by created_at asc', value: 'created_at asc'),
            new OA\Examples(example: 'created_at desc', summary: 'Sort by created_at desc', value: 'created_at desc'),
        ]
    )]
    #[OA\Parameter(
        name: 'type',
        in: 'query',
        required: true,
        schema: new OA\Schema(
            ref: new Model(type: PageType::class),
            default: PageType::Page->value,
        ),
    )]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Returns collection',
        content: new OA\JsonContent(
            ref: new Model(
                type: PageInfoCollectionDTO::class,
                groups: ['link_details', 'collection_meta', 'page_collection', 'article_collection']
            )
        ),
    )]
    #[OA\Tag(name: ApiDocTag::SITES)]
    public function __invoke(
        Uuid $id,
        #[CurrentUser] ApiSiteUser $user,
        MessageBusHandler $messageBusHandler,
        PageCriteriaDTOFactory $factory,
        GetSitePageCollectionRequest $request,
    ): JsonResponse {
        return $this->json(
            $messageBusHandler->handleQuery(
                new GetSitePageCollectionQuery(
                    siteId: $id,
                    token: $user->token,
                    criteria: $factory->fromCollectionRequest($request)
                )
            ),
            context: ['groups' => ['link_details', 'collection_meta', 'page_collection', 'article_collection']]
        );
    }
}
