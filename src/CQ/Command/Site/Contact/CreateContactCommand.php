<?php

declare(strict_types=1);

namespace App\CQ\Command\Site\Contact;

use Symfony\Component\Uid\Uuid;

/**
 * @see CreateContactHandler
 */
class CreateContactCommand
{
    public function __construct(
        public Uuid $siteId,
        public string $token,
        public ?string $name,
        public ?string $email,
        public ?string $message,
    ) {
    }
}
