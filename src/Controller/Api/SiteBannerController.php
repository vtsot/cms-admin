<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Contract\Dictionary\ApiDocTag;
use App\CQ\Query\Site\GetSiteRandomBannerQuery;
use App\DTO\Entity\BannerDTO;
use App\DTO\Entity\Site\SiteDTO;
use App\Service\MessageBusHandler;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route(
    path: '/api/sites/{siteId}/banners',
    requirements: ['siteId' => Requirement::UUID]
)]
class SiteBannerController extends AbstractController
{
    #[Route(
        path: '/random',
        name: 'api.site.banner.get-random',
        options: ['expose' => true],
        methods: ['GET']
    )]
    #[OA\Response(
        response: 200,
        description: 'Return site random banner',
        content: new OA\JsonContent(
            ref: new Model(
                type: SiteDTO::class,
                groups: ['banner_details', 'link_details'],
            )
        )
    )]
    #[OA\Response(ref: '#/components/responses/unauthorized', response: '401')]
    #[OA\Response(ref: '#/components/responses/forbidden', response: '403')]
    #[OA\Response(ref: '#/components/responses/not_found', response: '404')]
    #[OA\Tag(name: ApiDocTag::SITES)]
    public function getRandom(
        string $siteId,
        MessageBusHandler $messageBusHandler,
        #[CurrentUser] UserInterface $user,
    ): JsonResponse {
        /** @var BannerDTO $dto */
        $dto = $messageBusHandler->handleQuery(
            new GetSiteRandomBannerQuery(
                siteToken: $user->getUserIdentifier(),
                siteId: Uuid::fromString($siteId),
            )
        );

        return $this->json(
            data: $dto,
            context: ['groups' => ['banner_details', 'link_details']]
        );
    }
}
