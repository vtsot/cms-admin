<?php

declare(strict_types=1);

namespace App\Service\CmsEmbed;

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class GalleryImageCmsEmbed extends AbstractCmsEmbed
{
    public const ID    = 'gallery-images';
    public const LABEL = 'Gallery Images';
    public const HELP  = 'Gallery Images Embed Content';

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
