<?php

declare(strict_types=1);

namespace App\DTOFactory\Entity\Site;

use App\DTO\Entity\Site\SiteThemeDTO;
use App\Entity\Site\SiteSettings;
use Symfony\Component\Routing\RouterInterface;

readonly class SiteSettingsDTOFactory
{
    public const CONTEXT_FAVICON        = 'favicon';
    public const CONTEXT_IMAGE_POSITION = 'image-position';
    public const CONTEXT_IMAGE_TITLE    = 'image-title';
    public const CONTEXT_LINK_TITLE     = 'link-title';
    public const CONTEXT_LINK           = 'link';
    public const CONTEXT_DESKTOP_IMAGE  = 'desktop-image';
    public const CONTEXT_MOBILE_IMAGE   = 'mobile-image';

    public const CONTEXT_PRIMARY_COLOR   = 'primary-color';
    public const CONTEXT_TEXT_COLOR      = 'text-color';
    public const CONTEXT_TOP_BG_COLOR    = 'top-bg-color';
    public const CONTEXT_FOOTER_BG_COLOR = 'footer-bg-color';

    /** @var array<string, array{width: int, height: int}> */
    public const array SITE_IMAGE_DESKTOP_SIZE = [
        // theme code => width, height
        'default' => ['width' => 728, 'height' => 90],
    ];

    /** @var array<string, array{width: int, height: int}> */
    public const array SITE_IMAGE_MOBILE_SIZE = [
        // theme code => width, height
        'default' => ['width' => 300, 'height' => 50],
    ];

    public function __construct(
        private RouterInterface $routeGenerator,
    ) {
    }

    public function fromEntity(SiteSettings $siteSettings, array $context = []): SiteThemeDTO
    {
        $theme       = $siteTheme->getCode();
        $desktopSize = self::SITE_IMAGE_DESKTOP_SIZE[$theme] ?? self::SITE_IMAGE_DESKTOP_SIZE['default'];
        $mobileSize  = self::SITE_IMAGE_MOBILE_SIZE[$theme] ?? self::SITE_IMAGE_MOBILE_SIZE['default'];

        $favicon      = $this->getFaviconUrl($context[self::CONTEXT_FAVICON] ?? null);
        $desktopImage = $this->getImageUrl($context[self::CONTEXT_DESKTOP_IMAGE] ?? null, 'resize', $desktopSize['width'], $desktopSize['height']);
        $mobileImage  = $this->getImageUrl($context[self::CONTEXT_MOBILE_IMAGE] ?? null, 'resize', $mobileSize['width'], $mobileSize['height']);

        return new SiteThemeDTO(
            $siteTheme->getId(),
            $siteTheme->getTitle(),
            $siteTheme->getCode(),
            $favicon,
            $context[self::CONTEXT_IMAGE_POSITION] ?? null,
            $context[self::CONTEXT_IMAGE_TITLE] ?? null,
            $context[self::CONTEXT_LINK_TITLE] ?? null,
            $context[self::CONTEXT_LINK] ?? null,
            $desktopImage,
            $mobileImage,
            $context[self::CONTEXT_PRIMARY_COLOR] ?? null,
            $context[self::CONTEXT_TEXT_COLOR] ?? null,
            $context[self::CONTEXT_TOP_BG_COLOR] ?? null,
            $context[self::CONTEXT_FOOTER_BG_COLOR] ?? null,
        );
    }

    private function getFaviconUrl(?string $imageName): ?string
    {
        return $imageName
            ? $this->routeGenerator->generate('general.image.favicon', ['image' => $imageName])
            : null;
    }

    private function getImageUrl(?string $imageName, string $crop, int $width, int $height): ?string
    {
        return $imageName
            ? $this->routeGenerator->generate(
                'general.image',
                [
                    'type'   => 'site',
                    'crop'   => $crop,
                    'width'  => $width,
                    'height' => $height,
                    'image'  => $imageName,
                ]
            )
            : null;
    }
}
