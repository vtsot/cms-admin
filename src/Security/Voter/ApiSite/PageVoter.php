<?php

declare(strict_types=1);

namespace App\Security\Voter\ApiSite;

use App\Entity\Page\AbstractPage;
use App\Repository\Page\AbstractPageRepository;
use App\Repository\Site\SiteRepository;
use App\Security\User\ApiSiteUser;
use App\Security\Voter\VoterSubject;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
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
        private readonly SiteRepository $siteRepository,
        private readonly AbstractPageRepository $pageRepository,
    ) {
    }

    /**
     * @param VoterSubject $subject
     */
    protected function supports($attribute, $subject): bool
    {
        //        dd(
        //            $subject instanceof VoterSubject,
        //            ($subject->entry === AbstractPage::class || $subject->entry instanceof AbstractPage)
        // //            && (
        // //                (in_array($attribute, [self::LIST, self::CREATE], true) && ($subject->entry === AbstractPage::class))
        // //                || (in_array($attribute, [self::VIEW, self::UPDATE, self::DELETE], true) && $subject->entry instanceof AbstractPage)
        // //            )
        //        );

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
        return $this->pageRepository
            ->findOneActiveBySiteIdAndTokenAndPageId($subject->siteId, $apiSite->token, $subject->entry->getId())
            ?->getId()
            ?->equals($subject->entry->getId());
    }
}
