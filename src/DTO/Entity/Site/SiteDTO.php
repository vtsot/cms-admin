<?php

declare(strict_types=1);

namespace App\DTO\Entity\Site;

use App\DTO\Entity\NavigationDTO;
use App\DTOFactory\Entity\Site\SiteDTOFactory;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

/**
 * @see SiteDTOFactory
 */
readonly class SiteDTO
{
    public function __construct(
        #[Groups(['site_collection', 'site_details'])]
        #[OA\Property(type: 'string', format: 'uuid')]
        public Uuid $id,

        #[Groups(['site_collection', 'site_details'])]
        public string $domain,

        #[Groups(['site_collection', 'site_details'])]
        public ?SiteThemeDTO $theme,

        #[Groups(['site_collection', 'site_details'])]
        public ?string $title,

        #[Groups(['site_collection', 'site_details'])]
        public ?string $genericNames,

        #[Groups(['site_collection', 'site_details'])]
        public ?string $commonBrands,

        #[Groups(['site_collection', 'site_details'])]
        public ?string $footerText1,

        #[Groups(['site_collection', 'site_details'])]
        public ?string $footerText2,

        #[Groups(['site_collection', 'site_details'])]
        public ?string $copyrightText,

        #[Groups(['site_collection', 'site_details'])]
        public ?string $homepage,

        /** @var NavigationDTO[] */
        #[Groups(['site_collection', 'site_details'])]
        #[OA\Property(
            type: 'array',
            items: new OA\Items(
                ref: new Model(
                    type: NavigationDTO::class,
                    groups: ['navigation_collection'],
                )),
        )]
        public ?array $navigationTop,

        /** @var NavigationDTO[] */
        #[Groups(['site_collection', 'site_details'])]
        #[OA\Property(
            type: 'array',
            items: new OA\Items(
                ref: new Model(
                    type: NavigationDTO::class,
                    groups: ['navigation_collection'],
                )),
        )]
        public ?array $navigationBottom,
    ) {
    }
}
