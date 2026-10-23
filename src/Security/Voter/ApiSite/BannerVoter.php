<?php

declare(strict_types=1);

namespace App\Security\Voter\ApiSite;

use App\Entity\Site\Banner;
use App\Repository\Site\BannerRepository;
use App\Repository\Site\SiteRepository;
use App\Security\User\ApiSiteUser;
use App\Security\Voter\VoterSubject;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
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
        private readonly SiteRepository $siteRepository,
        private readonly BannerRepository $bannerRepository,
    ) {
    }

    /**
     * @param VoterSubject $subject
     */
    protected function supports($attribute, $subject): bool
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
        return $this->bannerRepository
            ->findOneActiveBySiteIdAndTokenAndBannerId($subject->siteId, $apiSite->token, $subject->entry->getId())
            ?->getId()
            ?->equals($subject->entry->getId());
    }
}
