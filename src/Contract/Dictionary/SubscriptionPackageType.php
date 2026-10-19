<?php

declare(strict_types=1);

namespace App\Contract\Dictionary;

use App\Contract\Dictionary\Traits\EnumValuesTrait;

enum SubscriptionPackageType: string
{
    use EnumValuesTrait;
    case Individual = 'individual';
    case Workshop   = 'workshop';

    public static function fromCookieValue(mixed $value): self
    {
        return self::tryFrom($value ?? '') ? self::from($value) : self::Individual;
    }
}
