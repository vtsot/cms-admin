<?php

declare(strict_types=1);

namespace App\Security\Voter\ApiSite;

use App\Entity\Site\Site;
use App\Repository\Site\SiteRepository;
use App\Security\User\ApiSiteUser;
use App\Security\Voter\VoterSubject;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

use function in_array;

class SiteVoter extends Voter
{
    public const string LIST   = 'SITE_LIST';
    public const string VIEW   = 'SITE_VIEW';
    public const string CREATE = 'SITE_CREATE';
    public const string UPDATE = 'SITE_UPDATE';
    public const string DELETE = 'SITE_DELETE';

    public function __construct(
        private readonly SiteRepository $siteRepository,
    ) {
    }

    /**
     * @param VoterSubject $subject
     */
    protected function supports($attribute, $subject): bool
    {
        return $subject instanceof VoterSubject
            && ($subject->entry === Site::class || $subject->entry instanceof Site)
            && (
                (in_array($attribute, [self::LIST, self::CREATE], true) && ($subject->entry === Site::class))
                || (in_array($attribute, [self::VIEW, self::UPDATE, self::DELETE], true) && $subject->entry instanceof Site)
            );
    }

    /**
     * @param VoterSubject $subject
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token, ?Vote $vote = null): bool
    {
        $apiSite = $token->getUser();

        if (!$apiSite instanceof ApiSiteUser) {
            return false;
        }

        return match ($attribute) {
            self::LIST => $this->voteOnClass($apiSite, $subject),
            self::VIEW => $this->voteOnInstance($apiSite, $subject),
            default    => false,
        };
    }

    private function voteOnClass(ApiSiteUser $apiSite, VoterSubject $subject): bool
    {
        return $this->siteRepository->findOneActiveBySiteIdAndToken($subject->siteId, $apiSite->token) !== null;
    }

    private function voteOnInstance(ApiSiteUser $apiSite, VoterSubject $subject): bool
    {
        return $this->siteRepository
            ->findOneActiveBySiteIdAndToken($subject->siteId, $apiSite->token)
            ?->getId()
            ?->equals($subject->entry->getId());
    }
}
