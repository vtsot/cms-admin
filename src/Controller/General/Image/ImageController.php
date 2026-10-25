<?php

declare(strict_types=1);

namespace App\Controller\General\Image;

use App\Controller\AbstractController;
use App\Message\Query\Site\GetArticleImageQuery;
use App\Message\Query\Site\GetBannerImageQuery;
use App\Message\Query\Site\GetSiteImageQuery;
use App\Service\MessageBusHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

class ImageController extends AbstractController
{
    #[Route(
        path: '/images/{type}/{crop}/{width}x{height}/{image}',
        name: 'general.image',
        requirements: [
            'type'   => 'site|favicon|banner|article',
            'crop'   => 'fit|resize',
            'width'  => Requirement::DIGITS,
            'height' => Requirement::DIGITS,
            'image'  => Requirement::UUID . Requirement::CATCH_ALL,
        ],
        options: ['expose' => true],
        methods: ['GET']
    )]
    public function __invoke(
        Request $request,
        MessageBusHandler $messageBusHandler,
        string $type,
        string $crop,
        int $width,
        int $height,
        string $image,
    ): Response {
        $imageFile = match ($type) {
            'site'    => $messageBusHandler->handleQuery(new GetSiteImageQuery($image, $crop, $width, $height)),
            'article' => $messageBusHandler->handleQuery(new GetArticleImageQuery($image, $crop, $width, $height)),
            'banner'  => $messageBusHandler->handleQuery(new GetBannerImageQuery($image, $crop, $width, $height)),
            default   => null,
        };

        if ($imageFile) {
            return $this->handleFileResponse($request, $imageFile);
        }

        throw $this->createNotFoundException();
    }
}
