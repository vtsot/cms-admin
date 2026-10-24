<?php

declare(strict_types=1);

namespace App\ControllerRequest\Api\Site;

use App\Contract\Dictionary\PageSitemapChangeFrequency;
use App\Contract\Dictionary\PageSitemapPriority;
use App\Contract\Dictionary\PageType;
use App\ControllerRequest\AbstractGetCollectionRequest;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class GetSitePageCollectionRequest extends AbstractGetCollectionRequest
{
    public function __construct(
        #[Assert\Choice(callback: [PageType::class, 'values'])]
        public ?string $type = null,

        ?int $page = self::DEFAULT_PAGE,
        ?int $perPage = self::DEFAULT_PER_PAGE,
        ?string $query = null,
        ?string $sort = 'created_at desc',

        #[Assert\Length(max: 255)]
        public ?string $slug = null,

        #[Assert\Choice(choices: [0, 1, '0', '1', true, false, 'true', 'false'], strict: true)]
        public mixed $active = null,

        #[Assert\Date]
        #[Assert\LessThanOrEqual(propertyPath: 'endDay')]
        #[OA\Property(format: 'date')]
        #[SerializedName('start_day')]
        public ?string $startDay = null,

        #[Assert\Date]
        #[Assert\GreaterThanOrEqual(propertyPath: 'startDay')]
        #[OA\Property(format: 'date')]
        #[SerializedName('end_day')]
        public ?string $endDay = null,

        #[Assert\Choice(choices: [0, 1, '0', '1', true, false, 'true', 'false'], strict: true)]
        public mixed $indexed = null,

        #[Assert\Choice(callback: [PageSitemapChangeFrequency::class, 'values'], message: 'Allowed values: {{ choices }}')]
        public ?string $frequency = null,

        #[Assert\Choice(callback: [PageSitemapPriority::class, 'values'], message: 'Allowed values: {{ choices }}')]
        public ?string $priority = null,
    ) {
        parent::__construct($page, $perPage, $query, $sort);
    }
}
