<?php

declare(strict_types=1);

namespace App\Controller\Web\Test\Site;

use App\CQ\Query\Site\Page\GetPageQuery;
use App\DTO\Entity\Page\ArticleDTO;
use App\DTO\Entity\Page\PageDTO;
use App\Service\MessageBusHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Uid\Uuid;

class GetSitePageController extends AbstractController
{
    /**
     * @example /test/sites/01a16459-7d94-7436-bef8-491f292baedf/pages/page-1
     **/
    #[Route(
        path: '/test/sites/{id}/pages/{slug}/',
        name: 'test.site.page.get',
        requirements: ['id' => Requirement::UUID, 'slug' => Requirement::ASCII_SLUG],
        options: ['expose' => true],
        methods: ['GET']
    )]
    public function __invoke(
        Request $request,
        Uuid $id,
        string $slug,
        MessageBusHandler $messageBusHandler,
        ?string $token = 'f5c500527d1655b4d39c7fa91f9b9a534c145d00',
    ): Response {
        /** @var PageDTO|ArticleDTO $dto */
        $page = null;
        //        $page = $messageBusHandler->handleQuery(
        //            new GetPageQuery(
        //                siteId: $id,
        //                token: $token,
        //                slug: $slug,
        //            )
        //        );

        return $this->render('web/test/site/page.html.twig', [
            'page' => $page ?? null,
        ]);
    }
}
