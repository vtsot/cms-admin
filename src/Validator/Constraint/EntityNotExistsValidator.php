<?php

declare(strict_types=1);

namespace App\Validator\Constraint;

use Doctrine\ORM\EntityManagerInterface;
use LogicException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Contracts\Translation\TranslatorInterface;

use function sprintf;

final class EntityNotExistsValidator extends ConstraintValidator
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly TranslatorInterface $translator,
    ) {
    }

    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof EntityNotExists) {
            throw new LogicException(sprintf('You can only pass %s constraint to this validator.', EntityNotExists::class));
        }

        if ($value === null || $value === '') {
            return;
        }

        if (empty($constraint->entity)) {
            throw new LogicException(sprintf('Must set "entity" on "%s" validator', EntityNotExists::class));
        }

        $data = $this->entityManager->getRepository($constraint->entity)->findOneBy([
            $constraint->property => $value,
        ]);

        if ($data !== null) {
            $this->context
                ->buildViolation($this->translator->trans($constraint->message))
                ->setParameter('%entity%', $constraint->entity)
                ->setParameter('%property%', $constraint->property)
                ->setParameter('%value%', (string) $value)
                ->addViolation();
        }
    }
}
