<?php

declare(strict_types=1);

namespace App\Controller\Web\Test\Site;

use App\DTO\Entity\Page\ArticleDetailsDTO;
use App\DTO\Entity\Page\PageDetailsDTO;
use App\Repository\Page\PageRepository;
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
     * The page is loaded in the {_locale} locale (default locale when omitted), see App\EventSubscriber\LocaleSubscriber.
     *
     * @example /test/sites/01a16459-7d94-7436-bef8-491f292baedf/pages/page-1
     * @example /test/sites/01a16459-7d94-7436-bef8-491f292baedf/pages/page-1/uk_UA
     **/
    #[Route(
        path: '/test/sites/{id}/pages/{slug}/{_locale}',
        name: 'test.site.page.get',
        requirements: ['id' => Requirement::UUID, 'slug' => Requirement::ASCII_SLUG, '_locale' => '%locale_requirement%'],
        options: ['expose' => true],
        defaults: ['_locale' => null],
        methods: ['GET']
    )]
    public function __invoke(
        Request $request,
        Uuid $id,
        string $slug,
        MessageBusHandler $messageBusHandler,
        PageRepository $pageRepository,
        ?string $token = 'f5c500527d1655b4d39c7fa91f9b9a534c145d00',
    ): Response {
        /** @var PageDetailsDTO|ArticleDetailsDTO $dto */
        //        $page = $messageBusHandler->handleQuery(
        //            new GetPageQuery(
        //                siteId: $id,
        //                token: $token,
        //                slug: $slug,
        //            )
        //        );

        $page = $pageRepository->findOneActiveBySiteIdAndTokenAndSlug($id, $token, $slug);

        return $this->render('web/test/site/page.html.twig', [
            'page' => $page ?? null,
        ]);
    }
}
