<?php

declare(strict_types=1);

namespace App\ControllerRequest\Api\Site;

use App\Contract\ControllerRequest\ControllerRequestInterface;
use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

use function array_diff;
use function count;
use function implode;
use function is_array;
use function sprintf;

readonly class CreateSiteContactRequest implements ControllerRequestInterface
{
    public function __construct(
        // the properties to update
        #[Assert\Count(min: 1)]
        #[Assert\All([
            new Assert\Type(type: 'string'),
            new NotBlank(),
        ])]
        #[OA\Property(description: 'List of all involved fields from the context', type: 'array', items: new OA\Items(type: 'string'))]
        public ?array $fields = [],

        #[Assert\Type('array')]
        #[OA\Property(description: 'List of required fields in the context', type: 'array', items: new OA\Items(type: 'string'))]
        public ?array $required = [],

        #[Assert\Type('array')]
        #[NotBlank]
        #[Assert\Callback(callback: [self::class, 'validateContext'])]
        #[OA\Property(description: 'Context', type: 'array', items: new OA\Items(type: 'mixed'))]
        public ?array $context = [],
    ) {
    }

    public static function validateContext(mixed $value, ExecutionContextInterface $context): void
    {
        if (empty($value)) {
            return;
        }

        $dto    = $context->getObject();
        $fields = $dto?->fields ?? [];

        if (empty($fields) || !is_array($value)) {
            return;
        }

        // Recursively collect all keys present at any level of the $context array
        $contextKeys = array_keys($value);

        // Find missing fields from the collected context keys
        $missingFields = array_diff($fields, $contextKeys);

        // If there are missing keys, trigger a validation error
        if (!empty($missingFields)) {
            $message = count($missingFields) === 1 ? 'SITE.CONTACT.CONTEXT_MISSING_FIELD' : 'SITE.CONTACT.CONTEXT_MISSING_FIELDS';
            $context->buildViolation($message)
                ->setParameter('%MISSING-FIELDS%', implode(', ', array_map(static fn ($key) => sprintf('"%s"', $key), $missingFields)))
                ->addViolation();

            return;
        }

        $requiredFields = [];

        foreach ($dto?->required ?? [] as $field) {
            $violations = $context->getValidator()->validate($value[$field] ?? null, new NotBlank());

            if ($violations->count()) {
                $requiredFields[] = $field;
            }
        }

        if ($requiredFields) {
            $message = count($requiredFields) === 1 ? 'SITE.CONTACT.CONTEXT_REQUIRED_FIELD' : 'SITE.CONTACT.CONTEXT_REQUIRED_FIELDS';
            $context->buildViolation($message)
                ->setParameter('%REQUIRED-FIELDS%', implode(', ', array_map(static fn ($key) => sprintf('"%s"', $key), $requiredFields)))
                ->addViolation();
        }
    }
}
