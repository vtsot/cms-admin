<?php

declare(strict_types=1);

namespace App\DTOFactory\ApiRequest;

use App\Exception\Validation\BadRequestException;
use App\Exception\Validation\ValidationFailedException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class ApiRequestFactory
{
    public function __construct(
        private DenormalizerInterface $denormalizer,
        private ValidatorInterface $validator,
        private TranslatorInterface $translator,
    ) {
    }

    /**
     * @template T
     *
     * @param class-string<T> $type
     *
     * @return T
     */
    public function fromArray(array $data, string $type): object
    {
        $object = $this->denormalize($data, $type);
        $this->validate($object);

        return $object;
    }

    private function denormalize(array $data, string $type): object
    {
        try {
            return $this->denormalizer->denormalize(
                $data,
                $type,
                JsonEncoder::FORMAT,
                [AbstractObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true]
            );
        } catch (NotNormalizableValueException) {
            throw new BadRequestException($this->translator->trans('GENERAL.BAD_REQUEST'));
        }
    }

    private function validate(object $object): void
    {
        $violations = $this->validator->validate($object);

        if ($violations->count()) {
            throw new ValidationFailedException(
                $this->translator->trans('GENERAL.REQUEST_VALIDATION_FAILED'),
                $violations
            );
        }
    }
}
