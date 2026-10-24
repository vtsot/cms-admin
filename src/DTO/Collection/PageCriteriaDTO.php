<?php

declare(strict_types=1);

namespace App\DTO\Collection;

use App\Contract\Dictionary\PageSitemapChangeFrequency;
use App\Contract\Dictionary\PageSitemapPriority;
use App\Contract\Dictionary\PageType;
use App\DTOFactory\Collection\PageCriteriaDTOFactory;
use Carbon\CarbonImmutable;

/**
 * @see PageCriteriaDTOFactory
 */
final readonly class PageCriteriaDTO
{
    public function __construct(
        public ?PageType $type = null,
        public ?int $page = null,
        public ?int $perPage = null,
        public ?string $query = null,
        public ?string $orderBy = null,
        public ?string $orderDirection = null,

        public ?string $slug = null,
        public ?bool $active = null,
        public ?CarbonImmutable $startDay = null,
        public ?CarbonImmutable $endDay = null,
        public ?bool $indexed = null,
        public ?PageSitemapChangeFrequency $frequency = null,
        public ?PageSitemapPriority $priority = null,
    ) {
    }
}
