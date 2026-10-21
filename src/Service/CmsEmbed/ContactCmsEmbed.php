<?php

declare(strict_types=1);

namespace App\Service\CmsEmbed;

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ContactCmsEmbed extends AbstractCmsEmbed
{
    public const ID    = 'contact';
    public const LABEL = 'Contact Us';
    public const HELP  = 'Contact Us Form Embed Content';

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
