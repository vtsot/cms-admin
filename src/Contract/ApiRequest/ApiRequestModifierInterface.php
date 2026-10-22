<?php

declare(strict_types=1);

namespace App\Contract\ApiRequest;

interface ApiRequestModifierInterface
{
    public function modify(mixed $value): mixed;
}
