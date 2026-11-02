<?php

declare(strict_types=1);

namespace App\Security\Voter\ApiSite;

use App\Contract\Dictionary\User\UserRole;
use App\Entity\Page\AbstractPage;
use App\Repository\Site\SiteRepository;
use App\Security\User\ApiSiteUser;
use App\Security\Voter\VoterSubject;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

use function in_array;

class PageVoter extends Voter
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
    protected function supports($attribute, $subject): bool
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

        if (!$user instanceof ApiSiteUser) {
            return false;
        }

        if ($this->authorizationChecker->isGranted(UserRole::Admin->value)) {
            return true;
        }

        return match ($attribute) {
            self::LIST => $this->voteOnClass($user, $subject),
            self::VIEW => $this->voteOnInstance($user, $subject),
            default    => false,
        };
    }

    private function voteOnClass(ApiSiteUser $user, VoterSubject $subject): bool
    {
        // user is a client of the site
        return $subject->siteId->equals($user->siteId)
            && ($site = $this->siteRepository->findOneActiveByApiSiteUser($user))
            && $site->getId()->equals($subject->siteId);
    }

    private function voteOnInstance(ApiSiteUser $user, VoterSubject $subject): bool
    {
        // user is a client of the site
        return $subject->siteId->equals($user->siteId)
            && ($site = $this->siteRepository->findOneActiveByApiSiteUser($user))
            && $site->getId()->equals($subject->siteId)
            // and entry belongs to the site
            && $subject->entry instanceof AbstractPage
            && $site->getId()->equals($subject->entry->getSite()?->getId());
    }
}
