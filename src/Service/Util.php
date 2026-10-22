<?php

declare(strict_types=1);

namespace App\Service;

use function explode;
use function sprintf;
use function str_contains;
use function Symfony\Component\String\s;
use function Symfony\Component\String\u;

use const DIRECTORY_SEPARATOR;
use const STR_PAD_LEFT;

class Util
{
    public const PATH_DEPTH = 2;

    public static function normalizeOrderBy(string $mainTable, string $orderBy, ?string $orderDirection): array
    {
        if (str_contains($orderBy, '.')) {
            [$table, $field] = explode('.', $orderBy);
        } else {
            $table = $mainTable;
            $field = $orderBy;
        }

        return [sprintf('%s.%s', $table, s($field)->camel()->toString()), $orderDirection];
    }

    public static function arrayKeysToSnake(array &$data): void
    {
        foreach (array_keys($data) as $key) {
            $value = &$data[$key];

            unset($data[$key]);

            $transformedKey = u($key)->snake()->toString();

            $data[$transformedKey] = $value;

            unset($value);
        }
    }

    /** @deprecated  */
    public static function normalizeFilePath(string $fileName, int $depth = 2, int $pathDepth = self::PATH_DEPTH): string
    {
        [$name, $extension] = explode('.', $fileName);

        $normalizedName = str_pad($name, $depth * 2, '0', STR_PAD_LEFT);

        $path = '';

        for ($i = 0; $i < $depth; $i++) {
            $path .= substr($normalizedName, $i * $pathDepth, $pathDepth) . DIRECTORY_SEPARATOR;
        }

        return $path . $name . '.' . $extension;
    }
}
