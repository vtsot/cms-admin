<?php

declare(strict_types=1);

namespace App\Validator\Constraint;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(Attribute::TARGET_PARAMETER | Attribute::TARGET_PROPERTY)]
final class EntityNotExists extends Constraint
{
    public function __construct(
        public string $entity,
        public string $message = 'Entity "%entity%" with property "%property%": "%value%" already exist.',
        public string $property = 'id',
        mixed $options = null,
        ?array $groups = null,
        mixed $payload = null,
    ) {
        parent::__construct($options, $groups, $payload);
    }
}
