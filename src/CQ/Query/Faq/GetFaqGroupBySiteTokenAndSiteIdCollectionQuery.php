<?php

declare(strict_types=1);

namespace App\CQ\Query\Faq;

use Symfony\Component\Uid\Uuid;

/**
 * @see GetFaqGroupBySiteTokenAndSiteIdCollectionHandler
 */
class GetFaqGroupBySiteTokenAndSiteIdCollectionQuery
{
    public function __construct(
        public ?string $siteToken = null,
        public ?Uuid $siteId = null,
    ) {
    }
}
