<?php

declare(strict_types=1);

namespace App\Message\Query\Site;

use App\Contract\Dictionary\NavigationType;
use App\MessageHandler\Query\Site\GetNavigationTreeHandler;
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
