<?php

declare(strict_types=1);

namespace App\DTO\Entity\Site;

use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\Uuid;

/**
 * @see SiteSettingsDTOFactory
 */
readonly class SiteSettingsDTO
{
    public function __construct(
        #[Groups(['site_settings_collection', 'site_settings_details'])]
        #[OA\Property(type: 'string', format: 'uuid')]
        public Uuid $id,

        #[Groups(['site_settings_collection', 'site_settings_details'])]
        public bool $isApiLogEnable,

        #[Groups(['site_settings_collection', 'site_settings_details'])]
        public ?string $favicon,

        #[Groups(['site_settings_collection', 'site_settings_details'])]
        public ?string $imageAlt,

        #[Groups(['site_theme_collection', 'site_theme_details'])]
        public ?string $desktopImage,

        #[Groups(['site_theme_collection', 'site_theme_details'])]
        public ?string $mobileImage,
    ) {
    }
}
