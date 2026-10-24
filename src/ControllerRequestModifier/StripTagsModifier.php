<?php

declare(strict_types=1);

namespace App\ControllerRequestModifier;

use App\Contract\ControllerRequest\ControllerRequestModifierInterface;
use Attribute;

use function array_map;
use function is_array;
use function is_string;
use function strip_tags;

#[Attribute(Attribute::TARGET_PROPERTY)]
final readonly class StripTagsModifier implements ControllerRequestModifierInterface
{
    /**
     * Trims string value. Returns NULL instead of empty string. Runs recursive for an array.
     *
     * @return string|mixed|null
     */
    public function modify(mixed $value): mixed
    {
        if (is_array($value)) {
            return array_map([$this, 'modify'], $value);
        }

        if (!is_string($value)) {
            return $value;
        }

        $trimmed = strip_tags($value);

        return $trimmed === '' ? null : $trimmed;
    }
}
