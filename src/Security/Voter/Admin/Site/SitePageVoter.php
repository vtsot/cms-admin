<?php

declare(strict_types=1);

namespace App\Security\Voter\Admin\Site;

use App\Contract\Dictionary\User\UserRole;
use App\Contract\Entity\UserInterface;
use App\Entity\Page\AbstractPage;
use App\Repository\Site\SiteRepository;
use App\Security\Voter\VoterSubject;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

use function in_array;

class SitePageVoter extends Voter
{
    public const string LIST   = 'PAGE_LIST';
    public const string VIEW   = 'PAGE_VIEW';
    public const string CREATE = 'PAGE_CREATE';
    public const string UPDATE = 'PAGE_UPDATE';
    public const string DELETE = 'PAGE_DELETE';

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
            && ($subject->entry === AbstractPage::class || $subject->entry instanceof AbstractPage)
            && (
                (in_array($attribute, [self::LIST, self::CREATE], true) && ($subject->entry === AbstractPage::class))
                || (in_array($attribute, [self::VIEW, self::UPDATE, self::DELETE], true) && $subject->entry instanceof AbstractPage)
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

        if ($this->authorizationChecker->isGranted(UserRole::Supervisor->value)) {
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
        return ($site = $this->siteRepository->findOneByIdAndUser($subject->siteId, $user->getId()))
            && $site->getId()->equals($subject->siteId);
    }

    private function voteOnInstance(UserInterface $user, VoterSubject $subject): bool
    {
        // user is a manager of the site
        // and entry belongs to the site
        return ($site = $this->siteRepository->findOneByIdAndUser($subject->siteId, $user->getId()))
            && $site->getId()->equals($subject->siteId)
            && $subject->entry instanceof AbstractPage
            && $site->getId()->equals($subject->entry->getSite()?->getId());
    }
}
