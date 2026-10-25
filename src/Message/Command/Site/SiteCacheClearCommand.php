<?php

declare(strict_types=1);

namespace App\Message\Command\Site;

use App\MessageHandler\Command\Site\SiteCacheClearHandler;

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
