<?php

declare(strict_types=1);

namespace App\Service\CmsEmbed;

use App\Contract\CmsEmbed\CmsEmbedInterface;
use App\Exception\Validation\UnprocessableEntityException;
use Symfony\Contracts\Service\Attribute\Required;
use Twig\Environment;
use Twig\Error\LoaderError;

use function preg_replace;
use function sprintf;
use function str_replace;
use function trim;

abstract class AbstractCmsEmbed implements CmsEmbedInterface
{
    public const ID          = '';
    public const LABEL       = '';
    public const HELP        = '';
    public const PLACEHOLDER = 'cms-embed/placeholder.html.twig';
    public const ACTIVE      = true;
    public const PARAMS      = [];

    protected Environment $twig;

    #[Required]
    public function initDependencies(
        Environment $twig,
    ): void {
        $this->twig = $twig;
    }

    public function getId(): string
    {
        return static::ID;
    }

    public function isActive(): bool
    {
        return static::ACTIVE;
    }

    public function getLabel(): string
    {
        return static::LABEL;
    }

    public function getHelp(): string
    {
        return static::HELP;
    }

    public function getParams(): array
    {
        return static::PARAMS;
    }

    private function resolvePlaceholderTemplate(): string
    {
        // try to find own placeholder template
        try {
            $template = 'cms-embed/' . $this->getId() . '/placeholder.html.twig';
            $this->twig->load($template);
        } catch (LoaderError $e) {
            // use default template
            $template = static::PLACEHOLDER;
        }

        // return template path
        return $template;
    }

    protected function resolveRenderTemplate(): string
    {
        // try to find own render template
        try {
            $template = 'cms-embed/' . $this->getId() . '/index.html.twig';
            $this->twig->load($template);
        } catch (LoaderError $e) {
            throw new UnprocessableEntityException(sprintf('Undefined cms-embed "%s" render template.', $template));
        }

        // return template path
        return $template;
    }

    public function getPlaceholder(): string
    {
        // generate placeholder content
        $placeholderTemplate = $this->resolvePlaceholderTemplate();
        $placeholderParams   = $this->getParams();
        $campaign            = false;

        foreach ($placeholderParams as $param) {
            if (($param['id'] ?? null) === self::CAMPAIGN_PARAM_ID) {
                $campaign = true;
            }
        }

        $params = [
            'cmsEmbedId' => $this->getId(),
            'label'      => $this->getLabel(),
            'help'       => $this->getHelp(),
            'visibility' => null,
            'campaign'   => $campaign,
        ];

        $result = $this->twig->render($placeholderTemplate, $params);
        $result = str_replace(["\r\n", "\n"], ' ', $result);
        $result = preg_replace('/  +/', ' ', $result);
        $result = trim($result);

        // return placeholder content
        return $result;
    }

    public function render(array $params = []): ?string
    {
        return null;
    }
}
