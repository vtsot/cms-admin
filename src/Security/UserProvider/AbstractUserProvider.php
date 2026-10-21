<?php

declare(strict_types=1);

namespace App\Security\UserProvider;

use App\Contract\Entity\UserInterface;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface as BaseUserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

use function get_class;
use function is_subclass_of;
use function sprintf;

abstract class AbstractUserProvider implements UserProviderInterface, PasswordUpgraderInterface
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly UserRepository $userRepository,
    ) {
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $user = $this->userRepository->findOneByIdentifier($identifier);

        if (!$user instanceof UserInterface) {
            $e = new UserNotFoundException(sprintf('User with id `%s` not found.', $identifier));
            $e->setUserIdentifier($identifier);

            throw $e;
        }

        return $user;
    }

    /**
     * @throws UserNotFoundException    if the user is not found
     * @throws UnsupportedUserException if the user is not supported
     */
    public function refreshUser(UserInterface|BaseUserInterface $user): UserInterface
    {
        if (!$user instanceof UserInterface) {
            throw new UnsupportedUserException(sprintf('Invalid user class "%s".', get_class($user)));
        }

        $refreshedUser = $this->userRepository->findOneById($user->getId());

        if (!$refreshedUser instanceof UserInterface) {
            $e = new UserNotFoundException(sprintf('User with id `%s` not found.', $user->getUserIdentifier()));
            $e->setUserIdentifier($user->getUserIdentifier());

            throw $e;
        }

        return $refreshedUser;
    }

    public function upgradePassword(UserInterface|PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        $user->setPassword($newHashedPassword);
        $this->em->persist($user);
        $this->em->flush();
    }

    public function supportsClass(string $class): bool
    {
        return $class === User::class;
        // || is_subclass_of($class, UserInterface::class);
    }
}
