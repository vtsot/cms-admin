<?php

declare(strict_types=1);

namespace App\Service\CmsEmbed\Helper;

use Symfony\Component\DomCrawler\Crawler;

use function html_entity_decode;
use function str_replace;

readonly class CmsEmbedRenderer
{
    public function __construct(
        private CmsEmbedCollection $cmsEmbedCollection,
    ) {
    }

    public function render(?string $content): ?string
    {
        if ($content === null) {
            return null;
        }

        $content = html_entity_decode($content);
        $crawler = new Crawler($content);

        $crawler->filter('[data-cms-embed-id]')->each(function (Crawler $crawler, $i) use (&$content) {
            $html       = '';
            $cmsEmbedId = $crawler->attr('data-cms-embed-id');

            // resolve target html to replace
            if ($cmsEmbedId !== null
                && ($cmsEmbed = $this->cmsEmbedCollection->getOneById($cmsEmbedId)) !== null
            ) {
                $params       = $cmsEmbed->getParams();
                $parsedParams = [];

                foreach ($params as $param) {
                    $node = $crawler->filter('[data-' . $param['id'] . ']')->getNode(0);

                    if ($node) {
                        $parsedParams[$param['id']] = $node->getAttribute('data-' . $param['id']);
                    }
                }

                $html = $cmsEmbed->render($parsedParams) ?? '';
            }

            // replace cms embed placeholder to html rendered result
            $source  = html_entity_decode($crawler->outerHtml());
            $content = str_replace($source, $html, $content);
        });

        return $content;
    }
}
