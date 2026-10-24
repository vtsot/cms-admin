<?php

declare(strict_types=1);

namespace App\Service;

use Carbon\CarbonImmutable;

use function array_combine;
use function array_keys;
use function array_map;
use function array_values;
use function filter_var;
use function Symfony\Component\String\u;

use const FILTER_NULL_ON_FAILURE;
use const FILTER_VALIDATE_BOOLEAN;

class Util
{
    public static function arrayKeysToSnake(array $data): array
    {
        return array_combine(
            array_map(
                static fn (string $key): string => u($key)->snake()->toString(),
                array_keys($data),
            ),
            array_values($data),
        );
    }

    public static function normalizeDate(?string $date): ?CarbonImmutable
    {
        return $date ? CarbonImmutable::createFromFormat('Y-m-d', $date) : null;
    }

    public static function normalizeBool(mixed $value): ?bool
    {
        if ($value === null) {
            return null;
        }

        return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    }
}
