<?php

declare(strict_types=1);

namespace App\DTO\Entity\Site;

use App\DTO\Entity\NavigationDTO;
use App\DTOFactory\Entity\Site\SiteDTOFactory;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Attribute\Groups;
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
        public ?string $title,

        #[Groups(['site_collection', 'site_details'])]
        public ?string $description,

        #[Groups(['site_collection', 'site_details'])]
        public ?string $homepage,

        /** @var NavigationDTO[] */
        #[Groups(['site_collection', 'site_details'])]
        #[OA\Property(
            type: 'array',
            items: new OA\Items(ref: new Model(
                type: NavigationDTO::class,
                groups: ['navigation_collection', 'navigation_details'],
            )))]
        public ?array $mainNavigation,
    ) {
    }
}
