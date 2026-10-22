<?php

declare(strict_types=1);

namespace App\DTOFactory\ApiRequest;

use App\Contract\ApiRequest\ApiRequestModifierInterface;
use App\Exception\Validation\BadRequestException;
use App\Exception\Validation\ValidationFailedException;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

use function Symfony\Component\String\u;

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
        $data   = $this->modify($data, $type);
        $object = $this->denormalize($data, $type);
        $this->validate($object);

        return $object;
    }

    /**
     * @param mixed[] $data
     *
     * @return mixed[]
     *
     * @throws ReflectionException
     */
    private function modify(array $data, string $type): array
    {
        $reflect = new ReflectionClass($type);

        foreach ($reflect->getProperties() as $property) {
            foreach ($property->getAttributes() as $attribute) {
                $modifier = $attribute->newInstance();

                if (!$modifier instanceof ApiRequestModifierInterface) {
                    continue;
                }

                $key = u($property->name)->snake()->toString();

                if (isset($data[$key])) {
                    $data[$key] = $modifier->modify($data[$key]);
                }
            }
        }

        return $data;
    }

    /**
     * @param mixed[] $data
     *
     * @throws ExceptionInterface
     */
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
            throw new BadRequestException($this->translator->trans(id: 'GENERAL.BAD_REQUEST', domain: 'validators'));
        }
    }

    private function validate(object $object): void
    {
        $violations = $this->validator->validate($object);

        if ($violations->count()) {
            throw new ValidationFailedException(
                $this->translator->trans(id: 'GENERAL.VALIDATION_FAILED', domain: 'validators'),
                $violations,
            );
        }
    }
}
