<?php

declare(strict_types=1);

namespace App\DTO\Collection;

use App\Contract\Dictionary\PageSitemapChangeFrequency;
use App\Contract\Dictionary\PageSitemapPriority;
use App\Contract\Dictionary\PageType;
use App\DTOFactory\Collection\PageCriteriaDTOFactory;
use App\ValueObject\LocaleVO;
use Carbon\CarbonImmutable;

/**
 * @see PageCriteriaDTOFactory
 */
final readonly class PageCriteriaDTO
{
    public const string FILTER_TYPE      = 'type';
    public const string FILTER_QUERY     = 'query';
    public const string FILTER_SLUG      = 'slug';
    public const string FILTER_ACTIVE    = 'active';
    public const string FILTER_START_DAY = 'start_day';
    public const string FILTER_END_DAY   = 'end_day';
    public const string FILTER_INDEXED   = 'indexed';
    public const string FILTER_FREQUENCY = 'frequency';
    public const string FILTER_PRIORITY  = 'priority';

    public const array FILTERS = [
        self::FILTER_TYPE      => true,
        self::FILTER_QUERY     => true,
        self::FILTER_SLUG      => true,
        self::FILTER_ACTIVE    => true,
        self::FILTER_START_DAY => true,
        self::FILTER_END_DAY   => true,
        self::FILTER_INDEXED   => true,
        self::FILTER_FREQUENCY => true,
        self::FILTER_PRIORITY  => true,
    ];

    public const array SORT_BY = [
        // front-end => query builder field
        'created_at' => 'p.createdAt',
        'title'      => 'p.title',
        'slug'       => 'p.slug',
        'indexed'    => 'p.indexed',
        'frequency'  => 'p.sitemapChangeFrequency',
        'priority'   => 'p.sitemapPriority',
    ];

    public function __construct(
        public ?LocaleVO $locale = null,
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

    public function availableSortBy(): array
    {
        return array_keys(self::SORT_BY);
    }

    public function availableFilters(): array
    {
        $availableFilters                         = self::FILTERS;
        $availableFilters[self::FILTER_TYPE]      = PageType::valueNames();
        $availableFilters[self::FILTER_FREQUENCY] = PageSitemapChangeFrequency::valueNames();
        $availableFilters[self::FILTER_PRIORITY]  = PageSitemapPriority::valueNames();

        return $availableFilters;
    }

    public function appliedFilters(?array $context = []): array
    {
        return array_merge([
            self::FILTER_TYPE      => $this->type?->value,
            self::FILTER_QUERY     => $this->query,
            self::FILTER_SLUG      => $this->slug,
            self::FILTER_ACTIVE    => $this->active,
            self::FILTER_START_DAY => $this->startDay?->format('Y-m-d'),
            self::FILTER_END_DAY   => $this->endDay?->format('Y-m-d'),
            self::FILTER_INDEXED   => $this->indexed,
            self::FILTER_FREQUENCY => $this->frequency,
            self::FILTER_PRIORITY  => $this->priority,
        ], $context);
    }

    public function filtersSort(): ?string
    {
        // resolve the key of self::SORT_BY
        $key = array_keys(self::SORT_BY, $this->orderBy, true)[0] ?? null;

        // key was not resolve, try to get the 1st key of self::SORT_BY
        if ($key === null) {
            $key = array_keys(self::SORT_BY)[0] ?? null;
        }

        return $key && $this->orderDirection
            ? ($key . ' ' . $this->orderDirection)
            : null;
    }
}
