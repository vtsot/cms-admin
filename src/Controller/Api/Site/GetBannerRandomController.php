<?php

declare(strict_types=1);

namespace App\Controller\Api\Site;

use App\Contract\Dictionary\ApiDocTag;
use App\DTO\Entity\Site\BannerDTO;
use App\Message\Query\Site\GetBannerRandomQuery;
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
class GetBannerRandomController extends AbstractController
{
    #[Route(
        path: '/sites/{id}/banners/random',
        name: 'api.site.banner.get-random',
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
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Return site random banner',
        content: new OA\JsonContent(
            ref: new Model(
                type: BannerDTO::class,
                groups: ['banner_details', 'link_details'],
            )
        )
    )]
    #[OA\Tag(name: ApiDocTag::SITES)]
    public function __invoke(
        Uuid $id,
        MessageBusHandler $messageBusHandler,
        #[CurrentUser] ApiSiteUser $user,
    ): JsonResponse {
        /** @var BannerDTO $dto */
        $dto = $messageBusHandler->handleQuery(
            new GetBannerRandomQuery(
                siteId: $id,
                token: $user->token,
            )
        );

        return $this->json(
            data: $dto,
            context: ['groups' => ['banner_details', 'link_details']]
        );
    }
}
