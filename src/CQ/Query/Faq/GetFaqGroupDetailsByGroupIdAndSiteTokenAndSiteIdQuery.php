<?php

declare(strict_types=1);

namespace App\CQ\Query\Faq;

use Symfony\Component\Uid\Uuid;

/**
 * @see GetFaqGroupDetailsByGroupIdAndSiteTokenAndSiteIdHandler
 */
class GetFaqGroupDetailsByGroupIdAndSiteTokenAndSiteIdQuery
{
    public function __construct(
        public string $siteToken,
        public Uuid $siteId,
        public readonly Uuid $faqGroupId,
    ) {
    }
}
