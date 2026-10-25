<?php

declare(strict_types=1);

namespace App\Controller\General\Image;

use App\Controller\AbstractController;
use App\Message\Query\Site\GetSiteFaviconQuery;
use App\Service\MessageBusHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

class FaviconController extends AbstractController
{
    #[Route(
        path: '/images/favicon/{image}',
        name: 'general.image.favicon',
        requirements: [
            'image' => Requirement::UUID . Requirement::CATCH_ALL,
        ],
        options: ['expose' => true],
        methods: ['GET']
    )]
    public function __invoke(
        Request $request,
        MessageBusHandler $messageBusHandler,
        string $image,
    ): Response {
        if ($imageFile = $messageBusHandler->handleQuery(new GetSiteFaviconQuery($image))) {
            return $this->handleFileResponse($request, $imageFile);
        }

        throw $this->createNotFoundException();
    }
}
