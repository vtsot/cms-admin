<?php

declare(strict_types=1);

namespace App\Security\Voter\Admin;

use App\Contract\Dictionary\User\UserRole;
use App\Contract\Entity\UserInterface;
use App\Entity\Contact;
use App\Entity\Site\Site;
use App\Repository\Site\SiteRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

use function array_key_exists;
use function in_array;
use function is_array;

class SiteContactVoter extends Voter
{
    public const LIST   = 'SITE_CONTACT_LIST';
    public const VIEW   = 'SITE_CONTACT_VIEW';
    public const CREATE = 'SITE_CONTACT_CREATE';
    public const UPDATE = 'SITE_CONTACT_UPDATE';
    public const DELETE = 'SITE_CONTACT_DELETE';

    public function __construct(
        private readonly AuthorizationCheckerInterface $authorizationChecker,
        private readonly SiteRepository $siteRepository,
    ) {
    }

    /**
     * @param array{0: Site, 1: string|Contact} $subject
     */
    protected function supports(string $attribute, $subject): bool
    {
        return is_array($subject)
            && array_key_exists(0, $subject)
            && array_key_exists(1, $subject)
            && $subject[0] instanceof Site
            && ($subject[1] === Contact::class || $subject[1] instanceof Contact)
            && (
                (in_array($attribute, [self::LIST, self::CREATE], true) && $subject[1] === Contact::class)
                || (in_array($attribute, [self::VIEW, self::UPDATE, self::DELETE], true) && $subject[1] instanceof Contact)
            );
    }

    /**
     * @param array{0: Site, 1: string|Contact} $subject
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

        [$targetSite, $contact] = $subject;

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
                    && $targetSite->getId()?->equals($contact?->getSite()?->getId());
        }

        return false;
    }
}
