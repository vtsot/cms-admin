<?php

declare(strict_types=1);

namespace App\Service\CmsEmbed;

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class BannerCmsEmbed extends AbstractCmsEmbed
{
    public const ID    = 'banner';
    public const LABEL = 'Banner';
    public const HELP  = 'Banner Embed Content';

    /**
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render(array $params = []): ?string
    {
        return $this->twig->render($this->resolveRenderTemplate());
    }
}
