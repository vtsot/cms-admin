<?php

declare(strict_types=1);

namespace App\ValueObject;

use App\Exception\Validation\InvalidArgumentException;
use Stringable;

use function strlen;
use function strtolower;
use function strtoupper;
use function substr;

class LocaleVO implements Stringable
{
    public function __construct(
        public readonly string $languageCode,
        public readonly string $countryCode,
    ) {
    }

    public static function fromString(string $locale): LocaleVO
    {
        if (strlen($locale) !== 5) {
            throw new InvalidArgumentException('Wrong locale string format');
        }

        return new self(
            strtolower(substr($locale, 0, 2)),
            strtolower(substr($locale, -2)),
        );
    }

    public function toString(string $divider = '_'): string
    {
        return $this->languageCode . $divider . strtoupper($this->countryCode);
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
