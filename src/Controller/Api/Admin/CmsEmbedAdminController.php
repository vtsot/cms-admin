<?php

declare(strict_types=1);

namespace App\Controller\Api\Admin;

use App\Contract\Dictionary\ApiDocTag;
use App\CQ\Query\CmsEmbed\GetCmsEmbedCollectionQuery;
use App\DTO\Collection\CmsEmbedCollectionDTO;
use App\Service\MessageBusHandler;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class CmsEmbedAdminController extends AbstractController
{
    #[Route(
        path: '/api/admin/cms-embeds',
        name: 'api.admin.cms_embed.collection',
        options: ['expose' => true],
        methods: ['GET']
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns cms-embed collection',
        content: new OA\JsonContent(
            ref: new Model(
                type: CmsEmbedCollectionDTO::class,
                groups: [
                    'cms_embed_collection',
                ],
            )
        )
    )]
    #[OA\Response(ref: '#/components/responses/invalid_json', response: '400')]
    #[OA\Response(ref: '#/components/responses/unauthorized', response: '401')]
    #[OA\Response(ref: '#/components/responses/forbidden', response: '403')]
    #[OA\Tag(name: ApiDocTag::ADMIN)]
    public function __invoke(
        MessageBusHandler $messageBusHandler,
    ): JsonResponse {
        /** @var CmsEmbedCollectionDTO $dto */
        $dto = $messageBusHandler->handleQuery(new GetCmsEmbedCollectionQuery());

        return $this->json(
            data: $dto,
            context: ['groups' => ['cms_embed_collection']],
        );
    }
}
