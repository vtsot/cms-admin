<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Contract\Dictionary\ApiDocTag;
use App\CQ\Query\Page\GetSitemapPageBySiteTokenAndSiteIdCollectionQuery;
use App\DTO\Collection\SitemapPageCollectionDTO;
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
    path: '/api/sites/{siteId}',
    requirements: ['siteId' => Requirement::UUID]
)]
class SitemapController extends AbstractController
{
    #[Route(
        path: '/sitemap-pages',
        name: 'api.site.sitemap.page.collection',
        options: ['expose' => true],
        methods: ['GET']
    )]
    #[OA\Response(
        response: 200,
        description: 'Return sitemap page collection',
        content: new OA\JsonContent(
            ref: new Model(
                type: SitemapPageCollectionDTO::class,
                groups: ['sitemap_page_collection'],
            )
        )
    )]
    #[OA\Response(ref: '#/components/responses/unauthorized', response: '401')]
    #[OA\Response(ref: '#/components/responses/forbidden', response: '403')]
    #[OA\Response(ref: '#/components/responses/not_found', response: '404')]
    #[OA\Tag(name: ApiDocTag::SITES)]
    public function getSitemapPageCollection(
        string $siteId,
        MessageBusHandler $messageBusHandler,
        #[CurrentUser] UserInterface $user,
    ): JsonResponse {
        /** @var SitemapPageCollectionDTO $dto */
        $dto = $messageBusHandler->handleQuery(
            new GetSitemapPageBySiteTokenAndSiteIdCollectionQuery(
                $user->getUserIdentifier(),
                Uuid::fromString($siteId),
            )
        );

        return $this->json(
            data: $dto,
            context: ['groups' => ['sitemap_page_collection']]
        );
    }
}
