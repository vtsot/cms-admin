<?php

declare(strict_types=1);

namespace App\Serializer\Normalizer;

use App\DTO\ErrorDTO;
use App\Exception\Validation\ValidationFailedException;
use App\Exception\Validation\ValidationFailedException as AppValidationFailedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\ValidationFailedException as SymfonyValidationFailedException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;
use Symfony\Contracts\Translation\TranslatorInterface;

use function count;
use function Symfony\Component\String\s;

class ValidationFailedExceptionNormalizer implements NormalizerInterface, SerializerAwareInterface
{
    use SerializerAwareTrait;

    public function __construct(
        private readonly TranslatorInterface $translator,
    ) {
    }

    /**
     * @param ValidationFailedException|SymfonyValidationFailedException $object
     */
    public function normalize(mixed $object, ?string $format = null, array $context = []): array
    {
        $errors = [];

        $replaceErrorMessage = null;

        foreach ($object->getViolations() as $item) {
            if ($item->getCode() === 'REPLACE_ERROR_MESSAGE') {
                $replaceErrorMessage = $item->getMessage();

                continue;
            }

            $errors[s($item->getPropertyPath())->snake()->toString()] = $item->getMessage();
        }

        $message = $object instanceof SymfonyValidationFailedException
            ? $this->translator->trans(id: 'GENERAL.VALIDATION_FAILED', domain: 'validators')
            : ($replaceErrorMessage ?? $object->getMessage());

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
        return $data instanceof AppValidationFailedException
            || $data instanceof SymfonyValidationFailedException;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            AppValidationFailedException::class     => true,
            SymfonyValidationFailedException::class => true,
        ];
    }
}
