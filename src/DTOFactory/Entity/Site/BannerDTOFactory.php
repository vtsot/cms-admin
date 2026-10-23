<?php

declare(strict_types=1);

namespace App\DTOFactory\Entity\Site;

use App\DTO\Entity\Site\BannerDTO;
use App\DTOFactory\Data\LinkDTOFactory;
use App\Entity\Site\Banner;
use Symfony\Component\Routing\RouterInterface;

readonly class BannerDTOFactory
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
        private LinkDTOFactory $linkDTOFactory,
        private RouterInterface $routeGenerator,
    ) {
    }

    public function fromEntity(
        Banner $banner,
    ): BannerDTO {
        $desktopSize = self::DESKTOP_SIZE['default'];
        $mobileSize  = self::MOBILE_SIZE['default'];

        $desktopImage = $this->getImageUrl($banner->getDesktopImage(), 'resize', $desktopSize['width'], $desktopSize['height']);
        $mobileImage  = $this->getImageUrl($banner->getMobileImage(), 'resize', $mobileSize['width'], $mobileSize['height']);

        $link = $banner->getLinkType() && ($banner->getLinkUrl() || $banner->getLinkPage())
            ? $this->linkDTOFactory->fromEntity($banner)
            : null;

        return new BannerDTO(
            id: $banner->getId(),
            title: $banner->getTitle(),
            imageAlt: $banner->getImageAlt(),
            desktopImage: $desktopImage,
            mobileImage: $mobileImage,
            link: $link,
        );
    }

    private function getImageUrl(?string $imageName, string $crop, int $width, int $height): ?string
    {
        return $imageName
            ? $this->routeGenerator->generate(
                'general.image',
                [
                    'type'   => 'banner',
                    'crop'   => $crop,
                    'width'  => $width,
                    'height' => $height,
                    'image'  => $imageName,
                ]
            )
            : null;
    }
}
