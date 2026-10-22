<?php

declare(strict_types=1);

namespace App\Security\Voter\Admin\Site;

use App\Contract\Dictionary\User\UserRole;
use App\Contract\Entity\UserInterface;
use App\Entity\Review\Review;
use App\Entity\Site\Site;
use App\Repository\Site\SiteRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

use function array_key_exists;
use function in_array;
use function is_array;

class SiteReviewVoter extends Voter
{
    public const LIST   = 'SITE_REVIEW_LIST';
    public const VIEW   = 'SITE_REVIEW_VIEW';
    public const CREATE = 'SITE_REVIEW_CREATE';
    public const UPDATE = 'SITE_REVIEW_UPDATE';
    public const DELETE = 'SITE_REVIEW_DELETE';

    public function __construct(
        private readonly AuthorizationCheckerInterface $authorizationChecker,
        private readonly SiteRepository $siteRepository,
    ) {
    }

    /**
     * @param array{0: Site, 1: string|Review} $subject
     */
    protected function supports(string $attribute, $subject): bool
    {
        return is_array($subject)
            && array_key_exists(0, $subject)
            && array_key_exists(1, $subject)
            && $subject[0] instanceof Site
            && ($subject[1] === Review::class || $subject[1] instanceof Review)
            && (
                (in_array($attribute, [self::LIST, self::CREATE], true) && $subject[1] === Review::class)
                || (in_array($attribute, [self::VIEW, self::UPDATE, self::DELETE], true) && $subject[1] instanceof Review)
            );
    }

    /**
     * @param array{0: Site, 1: string|Review} $subject
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

        [$targetSite, $review] = $subject;

        // site related to a user
        $site = $this->siteRepository->findOneByIdAndUser($targetSite->getId(), $user->getId());

        switch ($attribute) {
            case self::LIST:
            case self::CREATE:
                return $targetSite->getId()?->equals($site?->getId());
            case self::VIEW:
            case self::UPDATE:
            case self::DELETE:
                return $targetSite->getId()?->equals($site?->getId())
                    && $targetSite->getId()?->equals($review?->getSite()?->getId());
        }

        return false;
    }
}
