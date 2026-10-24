<?php

declare(strict_types=1);

namespace App\ControllerRequest\Api\Site;

use App\Contract\ControllerRequest\ControllerRequestInterface;
use App\ControllerRequestModifier\StripTagsModifier;
use App\ControllerRequestModifier\TrimModifier;
use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateSiteContactRequest implements ControllerRequestInterface
{
    public function __construct(
        #[TrimModifier]
        #[StripTagsModifier]
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        public ?string $name = null,

        #[TrimModifier]
        #[StripTagsModifier]
        #[Assert\NotBlank]
        #[Assert\Email]
        #[Assert\Length(max: 255)]
        public ?string $email = null,

        #[TrimModifier]
        #[StripTagsModifier]
        #[Assert\NotBlank]
        #[Assert\Length(max: 5000)]
        public ?string $message = null,
    ) {
    }
}
