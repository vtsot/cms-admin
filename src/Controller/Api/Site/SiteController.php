<?php

declare(strict_types=1);

namespace App\Controller\Api\Site;

use App\Contract\Dictionary\ApiDocTag;
use App\Controller\Api\Uuid;
use App\CQ\Query\Page\GetPageBySiteTokenAndSiteIdAndSlugQuery;
use App\CQ\Query\Site\GetSiteByTokenAndIdQuery;
use App\DTO\Entity\Page\PageDTO;
use App\DTO\Entity\Site\SiteDTO;
use App\Service\MessageBusHandler;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
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
class SiteController extends AbstractController
{
    #[Route(
        path: '',
        name: 'api.site.get',
        options: ['expose' => true],
        methods: ['GET']
    )]
    #[OA\Response(
        response: 200,
        description: 'Return site',
        content: new OA\JsonContent(
            ref: new Model(
                type: SiteDTO::class,
                groups: ['site_details', 'site_theme_details', 'link_details', 'navigation_collection'],
            )
        )
    )]
    #[OA\Response(ref: '#/components/responses/unauthorized', response: '401')]
    #[OA\Response(ref: '#/components/responses/forbidden', response: '403')]
    #[OA\Response(ref: '#/components/responses/not_found', response: '404')]
    #[OA\Tag(name: ApiDocTag::SITES)]
    public function get(
        string $siteId,
        MessageBusHandler $messageBusHandler,
        #[CurrentUser] UserInterface $user,
    ): JsonResponse {
        /** @var SiteDTO $dto */
        $dto = $messageBusHandler->handleQuery(
            new GetSiteByTokenAndIdQuery(
                $user->getUserIdentifier(),
                Uuid::fromString($siteId),
            )
        );

        return $this->json(
            data: $dto,
            context: ['groups' => ['site_details', 'site_theme_details', 'link_details', 'navigation_collection']]
        );
    }

    #[Route(
        path: '/pages/{slug}',
        name: 'api.site.page.get',
        requirements: ['slug' => Requirement::ASCII_SLUG],
        options: ['expose' => true],
        methods: ['GET']
    )]
    #[OA\Response(
        response: 200,
        description: 'Return site page',
        content: new OA\JsonContent(
            ref: new Model(
                type: PageDTO::class,
                groups: ['page_details', 'link_details', 'page_related_article_collection', 'article_collection'],
            )
        )
    )]
    #[OA\Response(ref: '#/components/responses/unauthorized', response: '401')]
    #[OA\Response(ref: '#/components/responses/forbidden', response: '403')]
    #[OA\Response(ref: '#/components/responses/not_found', response: '404')]
    #[OA\Tag(name: ApiDocTag::SITES)]
    public function getSitePage(
        string $siteId,
        string $slug,
        MessageBusHandler $messageBusHandler,
        #[CurrentUser] UserInterface $user,
    ): JsonResponse {
        /** @var PageDTO $dto */
        $dto = $messageBusHandler->handleQuery(
            new GetPageBySiteTokenAndSiteIdAndSlugQuery(
                $user->getUserIdentifier(),
                Uuid::fromString($siteId),
                $slug,
            )
        );

        return $this->json(
            data: $dto,
            context: ['groups' => ['page_details', 'link_details', 'page_related_article_collection', 'article_collection']]
        );
    }
}
