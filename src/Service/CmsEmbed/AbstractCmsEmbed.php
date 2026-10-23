<?php

declare(strict_types=1);

namespace App\Service\CmsEmbed;

use App\Contract\CmsEmbed\CmsEmbedInterface;
use App\Exception\Validation\UnprocessableEntityException;
use App\Security\User\ApiSiteUser;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Contracts\Service\Attribute\Required;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

use function preg_replace;
use function sprintf;
use function str_replace;
use function trim;

abstract class AbstractCmsEmbed implements CmsEmbedInterface
{
    public const string ID          = '';
    public const string LABEL       = '';
    public const string HELP        = '';
    public const string PLACEHOLDER = 'cms-embed/placeholder.html.twig';
    public const bool ACTIVE        = true;
    public const array PARAMS       = [];

    protected Environment $twig;
    protected TokenStorageInterface $tokenStorage;

    #[Required]
    public function initDependencies(
        Environment $twig,
        TokenStorageInterface $tokenStorage,
    ): void {
        $this->twig         = $twig;
        $this->tokenStorage = $tokenStorage;
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
        } catch (LoaderError|RuntimeError|SyntaxError $e) {
            throw new UnprocessableEntityException(sprintf('Undefined cms-embed "%s" render template.', $template));
        }

        // return template path
        return $template;
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
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

        // return placeholder content
        return trim($result);
    }

    public function getUser(): ?ApiSiteUser
    {
        /** @var ApiSiteUser|null $user */
        $user = $this->tokenStorage->getToken()?->getUser();

        return $user;
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function render(array $params = []): ?string
    {
        // by default, randed is equal to Placeholder
        // rendering runs on the client site
        return $this->getPlaceholder();
    }
}
