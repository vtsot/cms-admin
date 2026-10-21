<?php

declare(strict_types=1);

namespace App\Controller;

use App\CQ\Query\Banner\GetBannerImageQuery;
use App\CQ\Query\GalleryImage\GetGalleryImageQuery;
use App\CQ\Query\Page\GetArticleImageQuery;
use App\CQ\Query\Site\GetSiteFaviconQuery;
use App\CQ\Query\Site\GetSiteImageQuery;
use App\Service\MessageBusHandler;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route(path: '/images')]
class ImageController extends AbstractController
{
    #[Route(
        path: '/{type}/{crop}/{width}x{height}/{image}',
        name: 'general.image',
        requirements: [
            'type'   => 'gallery|banner|article|site',
            'crop'   => 'fit|resize',
            'width'  => Requirement::DIGITS,
            'height' => Requirement::DIGITS,
            //'image'  => Requirement::UUID . Requirement::CATCH_ALL . '|' . Uuid::NIL . Requirement::CATCH_ALL,
        ],
        options: ['expose' => true],
        methods: ['GET']
    )]
    public function image(
        Request $request,
        MessageBusHandler $messageBusHandler,
        string $type,
        string $crop,
        int $width,
        int $height,
        string $image,
    ): Response {
        $imageFile = $messageBusHandler->handleQuery(
            match ($type) {
                'gallery' => new GetGalleryImageQuery($image, $crop, $width, $height),
                'banner'  => new GetBannerImageQuery($image, $crop, $width, $height),
                'article' => new GetArticleImageQuery($image, $crop, $width, $height),
                'site'    => new GetSiteImageQuery($image, $crop, $width, $height),
            },
        );

        return $this->handleFileResponse($request, $imageFile);
    }

    #[Route(
        path: '/site/favicon/{image}',
        name: 'general.image.favicon',
//        requirements: [
//            'image' => Requirement::UUID . Requirement::CATCH_ALL . '|' . Uuid::NIL . Requirement::CATCH_ALL,
//        ],
        options: ['expose' => true],
        methods: ['GET']
    )]
    public function favicon(
        Request $request,
        MessageBusHandler $messageBusHandler,
        string $image,
    ): Response {
        $imageFile = $messageBusHandler->handleQuery(new GetSiteFaviconQuery($image));

        if ($imageFile) {
            return $this->handleFileResponse($request, $imageFile);
        }

        throw $this->createNotFoundException();
    }
}
