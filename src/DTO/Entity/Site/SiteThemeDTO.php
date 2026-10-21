<?php

declare(strict_types=1);

namespace App\DTO\Entity\Site;

use App\Contract\Dictionary\Site\SiteSettingsImagePosition;
use App\DTO\Data\LinkDTO;
use App\DTOFactory\Entity\Site\SiteThemeDTOFactory;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

/**
 * @see SiteThemeDTOFactory
 */
readonly class SiteThemeDTO
{
    public function __construct(
        #[Groups(['site_theme_collection', 'site_theme_details'])]
        #[OA\Property(type: 'string', format: 'uuid')]
        public Uuid $id,

        #[Groups(['site_theme_collection', 'site_theme_details'])]
        public ?string $title,

        #[Groups(['site_theme_collection', 'site_theme_details'])]
        public ?string $code,

        #[Groups(['site_theme_collection', 'site_theme_details'])]
        public ?string $favicon,

        #[Groups(['site_theme_collection', 'site_theme_details'])]
        #[OA\Property(type: 'string')]
        public ?SiteSettingsImagePosition $imagePosition,

        #[Groups(['site_theme_collection', 'site_theme_details'])]
        public ?string $imageTitle,

        #[Groups(['site_theme_collection', 'site_theme_details'])]
        public ?string $linkTitle,

        #[Groups(['site_theme_collection', 'site_theme_details'])]
        public ?LinkDTO $link,

        #[Groups(['site_theme_collection', 'site_theme_details'])]
        public ?string $desktopImage,

        #[Groups(['site_theme_collection', 'site_theme_details'])]
        public ?string $mobileImage,

        #[Groups(['site_theme_collection', 'site_theme_details'])]
        public ?string $primaryColor,

        #[Groups(['site_theme_collection', 'site_theme_details'])]
        public ?string $textColor,

        #[Groups(['site_theme_collection', 'site_theme_details'])]
        public ?string $topBgColor,

        #[Groups(['site_theme_collection', 'site_theme_details'])]
        public ?string $footerBgColor,
    ) {
    }
}
