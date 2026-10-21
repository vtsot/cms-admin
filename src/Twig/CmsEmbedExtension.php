<?php

declare(strict_types=1);

namespace App\Twig;

use App\Service\CmsEmbed\Helper\CmsEmbedRenderer;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class CmsEmbedExtension extends AbstractExtension
{
    public function __construct(
        private readonly CmsEmbedRenderer $cmsEmbedRenderer,
    ) {
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('cms_embed', [$this, 'renderCmsEmbed']),
        ];
    }

    public function renderCmsEmbed(?string $content): ?string
    {
        return $this->cmsEmbedRenderer->render($content);
    }
}
