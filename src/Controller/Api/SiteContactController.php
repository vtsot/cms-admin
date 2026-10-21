<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\ApiRequest\Site\CreateSiteContactRequest;
use App\Contract\Dictionary\ApiDocTag;
use App\CQ\Command\Site\CreateSiteContactCommand;
use App\Service\MessageBusHandler;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route(
    path: '/api/sites/{siteId}/contacts',
    requirements: ['siteId' => Requirement::UUID]
)]
class SiteContactController extends AbstractController
{
    #[Route(
        path: '',
        name: 'api.site.contact.post',
        options: ['expose' => true],
        methods: ['POST']
    )]
    #[OA\RequestBody(content: new OA\JsonContent(ref: new Model(type: CreateSiteContactRequest::class)))]
    #[OA\Response(response: 204, description: 'No content on success')]
    #[OA\Response(ref: '#/components/responses/invalid_json', response: '400')]
    #[OA\Response(ref: '#/components/responses/unauthorized', response: '401')]
    #[OA\Response(ref: '#/components/responses/forbidden', response: '403')]
    #[OA\Response(ref: '#/components/responses/not_found', response: '404')]
    #[OA\Response(ref: '#/components/responses/error', response: '422')]
    #[OA\Tag(name: ApiDocTag::SITES)]
    public function post(
        string $siteId,
        CreateSiteContactRequest $request,
        MessageBusHandler $messageBusHandler,
        #[CurrentUser] UserInterface $user,
    ): JsonResponse {
        $messageBusHandler->handleCommand(
            new CreateSiteContactCommand(
                siteToken: $user->getUserIdentifier(),
                siteId: Uuid::fromString($siteId),
                name: $request->name,
                email: $request->email,
                message: $request->message,
            )
        );

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
