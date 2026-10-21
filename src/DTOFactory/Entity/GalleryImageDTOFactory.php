<?php

declare(strict_types=1);

namespace App\DTOFactory\Entity;

use App\DTO\Entity\GalleryImageDTO;
use App\DTOFactory\Data\LinkDTOFactory;
use App\Entity\GalleryImage;
use App\Entity\Site\SiteTheme;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Routing\RouterInterface;

readonly class GalleryImageDTOFactory
{
    public const IMAGE_SIZE = [
        SiteTheme::THEME_BLUE_LIGHT => ['width' => 416, 'height' => 416],
        'default'                   => ['width' => 530, 'height' => 385],
    ];

    public const THUMBNAIL_SIZE = [
        SiteTheme::THEME_BLUE_LIGHT => ['width' => 115, 'height' => 106],
        'default'                   => ['width' => 325, 'height' => 235],
    ];

    public const THUMBNAIL_HEIGHT = 235;

    public function __construct(
        private LinkDTOFactory $linkDTOFactory,
        private RouterInterface $routeGenerator,
    ) {
    }

    public function fromEntity(
        GalleryImage $galleryImage,
    ): GalleryImageDTO {
        $id               = $galleryImage->getId() ?? Uuid::fromString(Uuid::NIL);
        $siteThemeCode    = $galleryImage->getSite()?->getSiteTheme()?->getCode();
        $thumbnailSizeKey = $siteThemeCode && isset(self::THUMBNAIL_SIZE[$siteThemeCode]) ? $siteThemeCode : 'default';
        $imageSizeKey     = $siteThemeCode && isset(self::IMAGE_SIZE[$siteThemeCode]) ? $siteThemeCode : 'default';
        $thumbnailSize    = self::THUMBNAIL_SIZE[$thumbnailSizeKey];
        $imageSize        = self::IMAGE_SIZE[$imageSizeKey];
        $link             = $galleryImage->getLinkType() && ($galleryImage->getLinkUrl() || $galleryImage->getLinkPage())
            ? $this->linkDTOFactory->fromEntity($galleryImage)
            : null;

        return new GalleryImageDTO(
            $id,
            $galleryImage->getTitle(),
            $galleryImage->getAlt(),
            $this->getImageUrl($galleryImage->getImage(), 'resize', $imageSize['width'], $imageSize['height']),
            $this->getImageUrl($galleryImage->getImage(), 'resize', $thumbnailSize['width'], $thumbnailSize['height']),
            $galleryImage->getColor(),
            $galleryImage->getShape(),
            $galleryImage->getImprint(),
            $galleryImage->getContent(),
            $link,
        );
    }

    private function getImageUrl(?string $imageName, string $crop, int $width, int $height): ?string
    {
        return $imageName
            ? $this->routeGenerator->generate(
                'general.image',
                [
                    'type'   => 'gallery',
                    'crop'   => $crop,
                    'width'  => $width,
                    'height' => $height,
                    'image'  => $imageName,
                ]
            )
            : null;
    }
}
