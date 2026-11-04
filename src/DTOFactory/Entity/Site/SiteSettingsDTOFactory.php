<?php

declare(strict_types=1);

namespace App\DTOFactory\Entity\Site;

use App\DTO\Entity\Site\SiteSettingsDTO;
use App\Entity\Site\SiteSettings;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Uid\NilUuid;

readonly class SiteSettingsDTOFactory
{
    /** @var array<string, array{width: int, height: int}> */
    public const array DESKTOP_SIZE = [
        // theme code => width, height
        'default' => ['width' => 728, 'height' => 90],
    ];

    /** @var array<string, array{width: int, height: int}> */
    public const array MOBILE_SIZE = [
        // theme code => width, height
        'default' => ['width' => 300, 'height' => 50],
    ];

    public function __construct(
        private RouterInterface $routeGenerator,
    ) {
    }

    public function fromEntity(SiteSettings $siteSettings): SiteSettingsDTO
    {
        $desktopSize = self::DESKTOP_SIZE['default'];
        $mobileSize  = self::MOBILE_SIZE['default'];

        $desktopImage = $this->getImageUrl($siteSettings->getDesktopImage(), 'resize', $desktopSize['width'], $desktopSize['height']);
        $mobileImage  = $this->getImageUrl($siteSettings->getMobileImage(), 'resize', $mobileSize['width'], $mobileSize['height']);

        return new SiteSettingsDTO(
            id: $siteSettings->getId() ?? new NilUuid(),
            isApiLogEnable: $siteSettings->isApiLogEnabled() ?? false,
            favicon: $this->getFaviconUrl($siteSettings?->getFavicon()),
            imageAlt: $siteSettings->getImageAlt(),
            desktopImage: $desktopImage,
            mobileImage: $mobileImage,
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
