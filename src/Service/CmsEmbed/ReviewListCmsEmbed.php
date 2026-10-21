<?php

declare(strict_types=1);

namespace App\Service\CmsEmbed;

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ReviewListCmsEmbed extends AbstractCmsEmbed
{
    public const ID    = 'review-list';
    public const LABEL = 'Review list';
    public const HELP  = 'Review list Embed Content';

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
