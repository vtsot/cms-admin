<?php

declare(strict_types=1);

namespace App\Message\Query\Site;

use App\MessageHandler\Query\Site\GetSiteDetailsHandler;
use Symfony\Component\Uid\Uuid;

/**
 * @see GetSiteDetailsHandler
 */
readonly class GetSiteDetailsQuery
{
    public function __construct(
        public Uuid $siteId,
        public string $token,
    ) {
    }
}
