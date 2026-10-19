<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\SupportRequest;

use App\Contract\Dictionary\Traits\EnumValuesTrait;

enum SupportRequestType: string
{
    use EnumValuesTrait;

    case Standard = 'standard';
    case Premium  = 'premium';

    public function isStandardType(): bool
    {
        return self::Standard->value === $this->value;
    }

    public function isPremiumType(): bool
    {
        return self::Premium->value === $this->value;
    }
}
