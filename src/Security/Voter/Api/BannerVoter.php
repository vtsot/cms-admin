<?php

declare(strict_types=1);

namespace App\Security\Voter\Api;

use App\Contract\Dictionary\User\UserRole;
use App\Contract\Entity\UserInterface;
use App\Domain\User\Entity\User;
use App\Domain\Vacancy\Entity\Vacancy;
use App\Entity\Site\Site;
use App\Entity\Site\Banner;
use App\Repository\Site\BannerRepository;
use App\Repository\Site\SiteRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

use Symfony\Component\Uid\Uuid;

use function array_key_exists;
use function in_array;
use function is_array;

class BannerVoter extends Voter
{
    public const string LIST   = 'BANNER_LIST';
    public const string VIEW   = 'BANNER_VIEW';
    public const string CREATE = 'BANNER_CREATE';
    public const string UPDATE = 'BANNER_UPDATE';
    public const string DELETE = 'BANNER_DELETE';

    public function __construct(
        private readonly AuthorizationCheckerInterface $authorizationChecker,
        private readonly BannerRepository $siteRepository,
    ) {
    }

    /**
     * @param array{
     *     0: Uuid|null,        # siteId
     *     1: string|Banner # subject
     * } $subject
     */
    protected function supports($attribute, $subject): bool
    {
        return is_array($subject)
            && array_key_exists(0, $subject)
            && array_key_exists(1, $subject)
            && ($subject[0] instanceof Uuid || $subject[0] === null)
            && ($subject[1] === Banner::class || $subject[1] instanceof Banner)
            && (
                (in_array($attribute, [self::LIST, self::CREATE], true) && $subject[1] === Banner::class)
                || (in_array(
                        $attribute,
                        [self::VIEW, self::UPDATE, self::DELETE],
                        true
                    ) && $subject[1] instanceof Banner)
            );
    }

    /**
     * @param array{
     *     0: Uuid|null,        # siteId
     *     1: string|Banner # subject
     * } $subject
     */
    protected function voteOnAttribute(
        string $attribute,
        mixed $subject,
        TokenInterface $token,
        ?Vote $vote = null,
    ): bool {

        return true;

        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        if ($this->authorizationChecker->isGranted(UserRole::SiteManager->value)) {
            return true;
        }

        [$siteId, $banner] = $subject;


        if (($user = $userId ? $this->userRepository->findOneById($userId) : null)
            && !$user instanceof User
        ) {
            return false;
        }

        return match ($attribute) {
            self::LIST,
            self::CREATE => true,

            self::VIEW,
            self::UPDATE,
            self::DELETE => ($user->hasRole(\App\Domain\User\Entity\UserRole::Supervisor->value) || $user->hasRole(UserRole::Admin->value))
                || ($subject instanceof Vacancy
                    && $this->vacancyRepository->findOneByIdAndUserId($subject->getId(), $user->getId()) !== null
                    && $user->getId() && $user->getId()->equals($subject->getUser()->getId())
                ),

            default => false,
        };
    }
}
