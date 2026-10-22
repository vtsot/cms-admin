<?php

declare(strict_types=1);

namespace App\CQ\Command\Site;

use Symfony\Component\Uid\Uuid;

/**
 * @see CreateSiteContactHandler
 */
readonly class CreateSiteContactCommand
{
    public function __construct(
        public string $siteToken,
        public Uuid $siteId,
        public ?string $name = null,
        public ?string $email = null,
        public ?string $message = null,
    ) {
    }
}
