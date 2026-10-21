<?php

declare(strict_types=1);

namespace App\ApiRequest\Site;

use App\Contract\ApiRequest\ApiRequestInterface;
use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateSiteContactRequest implements ApiRequestInterface
{
    public function __construct(
        #[Assert\NotBlank]
        public ?string $name = null,

        #[Assert\NotBlank]
        #[Assert\Email]
        public ?string $email = null,

        #[Assert\NotBlank]
        public ?string $message = null,
    ) {
    }
}
