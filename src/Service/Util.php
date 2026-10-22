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

    //    public const PATH_DEPTH = 2;
    //
    //    public static function normalizeOrderBy(string $mainTable, string $orderBy, ?string $orderDirection): array
    //    {
    //        if (str_contains($orderBy, '.')) {
    //            [$table, $field] = explode('.', $orderBy);
    //        } else {
    //            $table = $mainTable;
    //            $field = $orderBy;
    //        }
    //
    //        return [sprintf('%s.%s', $table, s($field)->camel()->toString()), $orderDirection];
    //    }
    //
    //    /** @deprecated  */
    //    public static function normalizeFilePath(string $fileName, int $depth = 2, int $pathDepth = self::PATH_DEPTH): string
    //    {
    //        [$name, $extension] = explode('.', $fileName);
    //
    //        $normalizedName = str_pad($name, $depth * 2, '0', STR_PAD_LEFT);
    //
    //        $path = '';
    //
    //        for ($i = 0; $i < $depth; $i++) {
    //            $path .= substr($normalizedName, $i * $pathDepth, $pathDepth) . DIRECTORY_SEPARATOR;
    //        }
    //
    //        return $path . $name . '.' . $extension;
    //    }
}
