<?php

declare(strict_types=1);

namespace App\Controller\Api\Site;

use App\Contract\Dictionary\ApiDocTag;
use App\CQ\Query\Site\Page\GetSitePageDetailsQuery;
use App\DTO\Entity\Page\ArticleDetailsDTO;
use App\DTO\Entity\Page\PageDetailsDTO;
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
class GetSitePageDetailsController extends AbstractController
{
    #[Route(
        path: '/sites/{id}/pages/{slug}',
        name: 'api.site.page.details',
        requirements: [
            'id'   => Requirement::UUID,
            'slug' => Requirement::ASCII_SLUG,
        ],
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
        description: 'Return site page',
        content: new OA\JsonContent(
            oneOf: [
                new OA\Schema(ref: new Model(
                    type: PageDetailsDTO::class,
                    groups: ['page_details', 'link_details', 'article_details'],
                )),
                new OA\Schema(ref: new Model(
                    type: ArticleDetailsDTO::class,
                    groups: ['page_details', 'link_details', 'article_details'],
                )),
            ]
        )
    )]
    #[OA\Tag(name: ApiDocTag::SITES)]
    public function __invoke(
        Uuid $id,
        string $slug,
        MessageBusHandler $messageBusHandler,
        #[CurrentUser] ApiSiteUser $user,
    ): JsonResponse {
        /** @var PageDetailsDTO|ArticleDetailsDTO $dto */
        $dto = $messageBusHandler->handleQuery(
            new GetSitePageDetailsQuery(
                siteId: $id,
                token: $user->token,
                slug: $slug,
            )
        );

        return $this->json(
            data: $dto,
            context: ['groups' => ['page_details', 'link_details', 'article_details']]
        );
    }
}
