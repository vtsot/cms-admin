<?php

declare(strict_types=1);

namespace App\CQ\Query\Site\Page;

use App\DTO\Collection\PageCriteriaDTO;
use Symfony\Component\Uid\Uuid;

/**
 * @see GetSitePageCollectionHandler
 */
final readonly class GetSitePageCollectionQuery
{
    // todo: move to criteria
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
        public Uuid $siteId,
        public string $token,
        public PageCriteriaDTO $criteria,
    ) {
    }
}
