<?php

declare(strict_types=1);

namespace App\Security;

use App\Contract\Entity\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface as BaseUserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface|BaseUserInterface $user): void
    {
        if (!$user instanceof UserInterface) {
            return;
        }

        if (!$user->isActive()) {
            throw new CustomUserMessageAccountStatusException('User account is disabled');
        }
    }

    public function checkPostAuth(BaseUserInterface $user, ?TokenInterface $token = null): void
    {
    }
}
