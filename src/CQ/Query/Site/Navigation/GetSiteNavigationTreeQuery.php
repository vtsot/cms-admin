<?php

declare(strict_types=1);

namespace App\CQ\Query\Site\Navigation;

use App\Contract\Dictionary\NavigationType;
use Symfony\Component\Uid\Uuid;

/**
 * @see GetSiteNavigationTreeHandler
 */
readonly class GetSiteNavigationTreeQuery
{
    public function __construct(
        public string $siteToken,
        public Uuid $siteId,
        public NavigationType $type,
    ) {
    }
}
