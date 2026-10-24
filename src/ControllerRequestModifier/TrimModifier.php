<?php

declare(strict_types=1);

namespace App\ControllerRequestModifier;

use App\Contract\ControllerRequest\ControllerRequestModifierInterface;
use Attribute;

use function array_map;
use function is_array;
use function is_string;
use function trim;

#[Attribute(Attribute::TARGET_PROPERTY)]
final readonly class TrimModifier implements ControllerRequestModifierInterface
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

        $trimmed = trim($value);

        return $trimmed === '' ? null : $trimmed;
    }
}
