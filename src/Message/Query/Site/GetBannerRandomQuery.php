<?php

declare(strict_types=1);

namespace App\Message\Query\Site;

use App\MessageHandler\Query\Site\GetBannerRandomHandler;
use Symfony\Component\Uid\Uuid;

/**
 * @see GetBannerRandomHandler
 */
class GetBannerRandomQuery
{
    public function __construct(
        public Uuid $siteId,
        public string $token,
    ) {
    }
}
