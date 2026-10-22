<?php

declare(strict_types=1);

namespace App\Security\Voter\Admin\Site;

use App\Contract\Dictionary\User\UserRole;
use App\Contract\Entity\UserInterface;
use App\Entity\Faq\Faq;
use App\Entity\Site\Site;
use App\Repository\Site\SiteRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

use function array_key_exists;
use function in_array;
use function is_array;

class SiteFaqVoter extends Voter
{
    public const LIST   = 'SITE_FAQ_LIST';
    public const VIEW   = 'SITE_FAQ_VIEW';
    public const CREATE = 'SITE_FAQ_CREATE';
    public const UPDATE = 'SITE_FAQ_UPDATE';
    public const DELETE = 'SITE_FAQ_DELETE';

    public function __construct(
        private readonly AuthorizationCheckerInterface $authorizationChecker,
        private readonly SiteRepository $siteRepository,
    ) {
    }

    /**
     * @param array{0: Site, 1: string|Faq} $subject
     */
    protected function supports(string $attribute, $subject): bool
    {
        return is_array($subject)
            && array_key_exists(0, $subject)
            && array_key_exists(1, $subject)
            && $subject[0] instanceof Site
            && ($subject[1] === Faq::class || $subject[1] instanceof Faq)
            && (
                (in_array($attribute, [self::LIST, self::CREATE], true) && $subject[1] === Faq::class)
                || (in_array($attribute, [self::VIEW, self::UPDATE, self::DELETE], true) && $subject[1] instanceof Faq)
            );
    }

    /**
     * @param array{0: Site, 1: string|Faq} $subject
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

        [$targetSite, $faq] = $subject;

        // site related to a user
        $site = $this->siteRepository->findOneByIdAndUser($targetSite->getId(), $user->getId());

        return match ($attribute) {
            self::LIST, self::CREATE               => $targetSite->getId()?->equals($site?->getId()),
            self::VIEW, self::UPDATE, self::DELETE => $targetSite->getId()?->equals($site?->getId())
                && $targetSite->getId()?->equals($faq?->getFaqGroup()?->getSite()?->getId()),
            default => false,
        };
    }
}
