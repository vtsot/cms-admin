<?php

declare(strict_types=1);

namespace App\Controller\Api\Site;

use App\Contract\Dictionary\ApiDocTag;
use App\CQ\Query\Faq\GetFaqGroupDetailsByGroupIdAndSiteTokenAndSiteIdQuery;
use App\DTO\Entity\Faq\FaqGroupDetailsDTO;
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
    path: '/api/sites/{siteId}/faq-groups',
    requirements: ['siteId' => Requirement::UUID]
)]
class SiteFaqGroupController extends AbstractController
{
    #[Route(
        path: '/{faqGroupId}/faqs',
        name: 'api.site.faq_group.faqs',
        options: ['expose' => true],
        methods: ['GET']
    )]
    #[OA\Response(
        response: 200,
        description: 'Return FAQ Group faqs details',
        content: new OA\JsonContent(
            ref: new Model(
                type: FaqGroupDetailsDTO::class,
                groups: ['faq_group_details', 'faq_details'],
            )
        )
    )]
    #[OA\Response(ref: '#/components/responses/invalid_json', response: '400')]
    #[OA\Response(ref: '#/components/responses/unauthorized', response: '401')]
    #[OA\Response(ref: '#/components/responses/forbidden', response: '403')]
    #[OA\Response(ref: '#/components/responses/not_found', response: '404')]
    #[OA\Response(ref: '#/components/responses/error', response: '422')]
    #[OA\Tag(name: ApiDocTag::SITES)]
    public function faqs(
        string $siteId,
        string $faqGroupId,
        MessageBusHandler $messageBusHandler,
        #[CurrentUser] UserInterface $user,
    ): JsonResponse {
        /** @var FaqGroupDetailsDTO $dto */
        $dto = $messageBusHandler->handleQuery(
            new GetFaqGroupDetailsByGroupIdAndSiteTokenAndSiteIdQuery(
                siteToken: $user->getUserIdentifier(),
                siteId: Uuid::fromString($siteId),
                faqGroupId: Uuid::fromString($faqGroupId),
            )
        );

        return $this->json(
            data: $dto,
            context: [
                'groups' => ['faq_group_details', 'faq_details'],
            ]
        );
    }
}
