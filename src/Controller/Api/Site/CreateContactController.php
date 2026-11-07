<?php

declare(strict_types=1);

namespace App\Controller\Api\Site;

use App\Contract\Dictionary\ApiDocTag;
use App\ControllerRequest\Api\Site\CreateSiteContactRequest;
use App\Message\Command\Site\CreateSiteContactCommand;
use App\Security\User\ApiSiteUser;
use App\Service\Log\AppLogger;
use App\Service\MessageBusHandler;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Uid\Uuid;

#[Route(host: '%api_domain%')]
class CreateContactController extends AbstractController
{
    #[Route(
        path: '/sites/{id}/contacts',
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
    #[OA\RequestBody(content: new OA\JsonContent(ref: new Model(type: CreateSiteContactRequest::class)))]
    #[OA\Response(response: Response::HTTP_NO_CONTENT, description: 'No content on success')]
    #[OA\Tag(name: ApiDocTag::SITES)]
    public function __invoke(
        Uuid $id,
        AppLogger $logger,
        Request $httpRequest,
        #[CurrentUser] ApiSiteUser $user,
        CreateSiteContactRequest $request,
        MessageBusHandler $messageBusHandler,
    ): JsonResponse {
        if ($user->isApiLogEnabled) {
            $logger->debug('api.site.contact.post', $logger::contextFromRequest($httpRequest, [
                'siteId'  => $user->siteId,
                'request' => $request,
                'payload' => $user,
            ]));
        }

        $messageBusHandler->handleCommand(
            new CreateSiteContactCommand(
                user: $user,
                fields: $request->fields,
                context: $request->context,
            )
        );

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
