<?php

declare(strict_types=1);

namespace App\Exception\Validation;

use App\Exception\AppException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationFailedException extends AppException
{
    private ConstraintViolationListInterface $violations;

    public function __construct(?string $message, ConstraintViolationListInterface $violations)
    {
        $this->violations = $violations;

        parent::__construct($message, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @return ConstraintViolationInterface[]|ConstraintViolationListInterface
     */
    public function getViolations(): ConstraintViolationListInterface
    {
        return $this->violations;
    }

    /**
     * @param array<int, array{message: string, path: string, value: mixed}> $violations
     */
    public static function fromArray(array $violations, string $message = 'Validation failed'): ValidationFailedException
    {
        $exceptions = [];

        foreach ($violations as $violation) {
            $exceptions[] = new ConstraintViolation(
                $violation['message'] ?? '',
                null,
                [],
                null,
                $violation['path'] ?? '',
                $violation['value'] ?? null
            );
        }

        return new self($message, new ConstraintViolationList($exceptions));
    }
}
