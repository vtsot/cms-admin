<?php

declare(strict_types=1);

namespace App\CQ\Command\Site;

/**
 * @see SiteCacheClearHandler
 */
readonly class SiteCacheClearCommand
{
    public function __construct(
        public string $domain,
        public string $token,
    ) {
    }
}
