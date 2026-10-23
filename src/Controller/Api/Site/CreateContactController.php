<?php

declare(strict_types=1);

namespace App\Controller\Api\Site;

use App\ApiRequest\Site\CreateContactRequest;
use App\Contract\Dictionary\ApiDocTag;
use App\CQ\Command\Site\Contact\CreateContactCommand;
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

class CreateContactController extends AbstractController
{
    #[Route(
        path: '/api/sites/{id}/contacts',
        name: 'api.site.contact.post',
        requirements: ['id' => Requirement::UUID],
        options: ['expose' => true],
        methods: ['POST']
    )]
    #[OA\Parameter(ref: '#/components/parameters/accept_language')]
    #[OA\Response(ref: '#/components/responses/error', response: Response::HTTP_UNPROCESSABLE_ENTITY)]
    #[OA\Response(ref: '#/components/responses/invalid_json', response: Response::HTTP_BAD_REQUEST)]
    #[OA\Response(ref: '#/components/responses/invalid_credentials', response: Response::HTTP_UNAUTHORIZED)]
    #[OA\Response(ref: '#/components/responses/forbidden', response: Response::HTTP_FORBIDDEN)]
    #[OA\Response(ref: '#/components/responses/not_found', response: Response::HTTP_NOT_FOUND)]
    #[OA\RequestBody(content: new OA\JsonContent(ref: new Model(type: CreateContactRequest::class)))]
    #[OA\Response(response: Response::HTTP_NO_CONTENT, description: 'No content on success')]
    #[OA\Tag(name: ApiDocTag::SITES)]
    public function __invoke(
        Uuid $id,
        CreateContactRequest $request,
        MessageBusHandler $messageBusHandler,
        #[CurrentUser] ApiSiteUser $user,
    ): JsonResponse {
        $messageBusHandler->handleCommand(
            new CreateContactCommand(
                siteId: $id,
                token: $user->token,
                name: $request->name,
                email: $request->email,
                message: $request->message,
            )
        );

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
