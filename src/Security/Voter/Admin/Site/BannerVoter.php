<?php

declare(strict_types=1);

namespace App\Security\Voter\Admin\Site;

use App\Contract\Dictionary\User\UserRole;
use App\Contract\Entity\UserInterface;
use App\Entity\Site\Banner;
use App\Repository\Site\SiteRepository;
use App\Security\Voter\VoterSubject;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

use function in_array;

class BannerVoter extends Voter
{
    public const string LIST   = 'BANNER_LIST';
    public const string VIEW   = 'BANNER_VIEW';
    public const string CREATE = 'BANNER_CREATE';
    public const string UPDATE = 'BANNER_UPDATE';
    public const string DELETE = 'BANNER_DELETE';

    public function __construct(
        private readonly AuthorizationCheckerInterface $authorizationChecker,
        private readonly SiteRepository $siteRepository,
    ) {
    }

    /**
     * @param VoterSubject $subject
     */
    protected function supports(string $attribute, $subject): bool
    {
        return $subject instanceof VoterSubject
            && ($subject->entry === Banner::class || $subject->entry instanceof Banner)
            && (
                (in_array($attribute, [self::LIST, self::CREATE], true) && ($subject->entry === Banner::class))
                || (in_array($attribute, [self::VIEW, self::UPDATE, self::DELETE], true) && $subject->entry instanceof Banner)
            );
    }

    /**
     * @param VoterSubject $subject
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token, ?Vote $vote = null): bool
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        if ($this->authorizationChecker->isGranted(UserRole::Admin->value)) {
            return true;
        }

        return match ($attribute) {
            self::LIST,
            self::CREATE => $this->voteOnClass($user, $subject),

            self::VIEW,
            self::DELETE,
            self::UPDATE => $this->voteOnInstance($user, $subject),

            default => false,
        };
    }

    private function voteOnClass(UserInterface $user, VoterSubject $subject): bool
    {
        // user is a manager of the site
        return ($site = $this->siteRepository->findOneByIdAndUserId($subject->siteId, $user->getId()))
            && $site->getId()->equals($subject->siteId);
    }

    private function voteOnInstance(UserInterface $user, VoterSubject $subject): bool
    {
        // user is a manager of the site
        return ($site = $this->siteRepository->findOneByIdAndUserId($subject->siteId, $user->getId()))
            && $site->getId()->equals($subject->siteId)
            // and entry belongs to the site
            && $subject->entry instanceof Banner
            && $site->getId()->equals($subject->entry->getSite()?->getId());
    }
}
