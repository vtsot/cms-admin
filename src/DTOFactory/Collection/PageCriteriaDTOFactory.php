<?php

declare(strict_types=1);

namespace App\DTOFactory\Collection;

use App\Contract\Dictionary\PageSitemapChangeFrequency;
use App\Contract\Dictionary\PageSitemapPriority;
use App\Contract\Dictionary\PageType;
use App\ControllerRequest\Api\Site\GetSitePageCollectionRequest;
use App\DTO\Collection\PageCriteriaDTO;
use App\Service\Util;
use App\ValueObject\LocaleVO;

use function trim;

class PageCriteriaDTOFactory
{
    public const string CONTEXT_TYPE = 'type';

    public function fromCollectionRequest(
        LocaleVO $locale,
        GetSitePageCollectionRequest $request,
        array $context = [],
    ): PageCriteriaDTO {
        return new PageCriteriaDTO(
            locale: $locale,
            type: $context[self::CONTEXT_TYPE] ?? PageType::tryFrom($request->type ?? ''),
            page: $request->page,
            perPage: $request->perPage,
            query: trim($request->query ?: '') ?: null,
            orderBy: PageCriteriaDTO::SORT_BY[$request->orderBy] ?? PageCriteriaDTO::SORT_BY[0] ?? null,
            orderDirection: $request->orderDirection,

            slug: $request->slug,
            active: Util::normalizeBool($request->active) ?? true,
            startDay: Util::normalizeDate($request->startDay),
            endDay: Util::normalizeDate($request->endDay),
            indexed: Util::normalizeBool($request->indexed),
            frequency: PageSitemapChangeFrequency::tryFrom($request->frequency ?? ''),
            priority: PageSitemapPriority::tryFrom($request->priority ?? ''),
        );
    }
}
