<?php

declare(strict_types=1);

namespace App\CQ\Query\Site\Navigation;

use App\Contract\Dictionary\NavigationType;
use Symfony\Component\Uid\Uuid;

/**
 * @see GetNavigationTreeHandler
 */
readonly class GetNavigationTreeQuery
{
    public function __construct(
        public Uuid $siteId,
        public string $token,
        public NavigationType $type,
    ) {
    }
}
