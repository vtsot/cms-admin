<?php

declare(strict_types=1);

namespace App\Contract\ControllerRequest;

interface ControllerRequestModifierInterface
{
    public function modify(mixed $value): mixed;
}
