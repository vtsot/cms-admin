<?php

declare(strict_types=1);

namespace App\EntityListener;

use App\Contract\Entity\EntityListenerInterface;
use App\Contract\Entity\UserInterface;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

#[AsEntityListener(event: Events::prePersist, method: 'prePersist', entity: User::class)]
#[AsEntityListener(event: Events::preUpdate, method: 'preUpdate', entity: User::class)]
final readonly class UserEntityListener implements EntityListenerInterface
{
    public function __construct(
        private PasswordHasherFactoryInterface $passwordHasherFactory,
    ) {
    }

    public function prePersist(User $user): void
    {
        $this->updateUserPassword($user);
    }

    public function preUpdate(User $user): void
    {
        $this->updateUserPassword($user);
    }

    private function updateUserPassword(UserInterface $user): void
    {
        $plainPassword = $user->getPlainPassword();

        if ($plainPassword !== null) {
            $user->setPassword($this->passwordHasherFactory->getPasswordHasher($user)->hash($plainPassword));
        }
    }
}
