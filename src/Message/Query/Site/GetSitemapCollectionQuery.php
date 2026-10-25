<?php

declare(strict_types=1);

namespace App\Message\Query\Site;

use App\MessageHandler\Query\Site\GetSitemapCollectionHandler;
use Symfony\Component\Uid\Uuid;

/**
 * @see GetSitemapCollectionHandler
 */
readonly class GetSitemapCollectionQuery
{
    public function __construct(
        public Uuid $siteId,
        public string $token,
    ) {
    }
}
