<?php

declare(strict_types=1);

namespace App\Serializer\Normalizer;

use App\DTO\ErrorDTO;
use App\Exception\Validation\ValidationFailedException as AppValidationFailedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\ValidationFailedException as SymfonyValidationFailedException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;

use function count;
use function Symfony\Component\String\s;

class ValidationFailedExceptionNormalizer implements NormalizerInterface, SerializerAwareInterface
{
    use SerializerAwareTrait;

    /**
     * @param AppValidationFailedException|SymfonyValidationFailedException $object
     */
    public function normalize(mixed $object, ?string $format = null, array $context = []): array
    {
        $errors = [];

        foreach ($object->getViolations() as $item) {
            $errors[s($item->getPropertyPath())->snake()->toString()] = $item->getMessage();
        }

        $message = $object instanceof SymfonyValidationFailedException
            ? 'Validation failed'
            : $object->getMessage();

        $dto = new ErrorDTO(
            Response::HTTP_UNPROCESSABLE_ENTITY,
            $message,
            [
                'fields' => count($errors) ? $errors : null,
            ]
        );

        return $this->serializer->normalize($dto, $format, $context);
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof AppValidationFailedException || $data instanceof SymfonyValidationFailedException;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            AppValidationFailedException::class     => true,
            SymfonyValidationFailedException::class => true,
        ];
    }
}
