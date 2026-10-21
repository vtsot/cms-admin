<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Contract\Dictionary\ApiDocTag;
use App\CQ\Query\Site\GetSiteGalleryImageCollectionQuery;
use App\DTO\Collection\GalleryImageCollectionDTO;
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
    path: '/api/sites/{siteId}/gallery-images',
    requirements: ['siteId' => Requirement::UUID]
)]
class SiteGalleryImageController extends AbstractController
{
    #[Route(
        path: '',
        name: 'api.site.gallery_image.collection',
        options: ['expose' => true],
        methods: ['GET']
    )]
    #[OA\Response(
        response: 200,
        description: 'Return site gallery image collection',
        content: new OA\JsonContent(
            ref: new Model(
                type: GalleryImageCollectionDTO::class,
                groups: [
                    'gallery_image_collection',
                    'link_details',
                ],
            )
        )
    )]
    #[OA\Response(ref: '#/components/responses/invalid_json', response: '400')]
    #[OA\Response(ref: '#/components/responses/unauthorized', response: '401')]
    #[OA\Response(ref: '#/components/responses/forbidden', response: '403')]
    #[OA\Response(ref: '#/components/responses/not_found', response: '404')]
    #[OA\Response(ref: '#/components/responses/error', response: '422')]
    #[OA\Tag(name: ApiDocTag::SITES)]
    public function collection(
        string $siteId,
        MessageBusHandler $messageBusHandler,
        #[CurrentUser] UserInterface $user,
    ): JsonResponse {
        /** @var GalleryImageCollectionDTO $dto */
        $dto = $messageBusHandler->handleQuery(
            new GetSiteGalleryImageCollectionQuery(
                siteToken: $user->getUserIdentifier(),
                siteId: Uuid::fromString($siteId),
            )
        );

        return $this->json(
            data: $dto,
            context: [
                'groups' => [
                    'gallery_image_collection',
                    'link_details',
                ],
            ]
        );
    }
}
