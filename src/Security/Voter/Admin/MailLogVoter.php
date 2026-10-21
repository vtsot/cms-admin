<?php

declare(strict_types=1);

namespace App\Security\Voter\Admin;

use App\Contract\Dictionary\User\UserRole;
use App\Contract\Entity\UserInterface;
use App\Entity\MailLog;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

use function in_array;

class MailLogVoter extends Voter
{
    public const LIST   = 'MAIL_LOG_LIST';
    public const VIEW   = 'MAIL_LOG_VIEW';
    public const CREATE = 'MAIL_LOG_CREATE';
    public const UPDATE = 'MAIL_LOG_UPDATE';
    public const DELETE = 'MAIL_LOG_DELETE';

    public function __construct(
        private readonly AuthorizationCheckerInterface $authorizationChecker,
    ) {
    }

    /**
     * @param string|MailLog $subject
     */
    protected function supports(string $attribute, $subject): bool
    {
        return ($subject === MailLog::class || $subject instanceof MailLog)
            && (
                (in_array($attribute, [self::LIST, self::CREATE], true) && $subject === MailLog::class)
                || (in_array($attribute, [self::VIEW, self::UPDATE, self::DELETE], true) && $subject instanceof MailLog)
            );
    }

    /**
     * @param string|MailLog $subject
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token, ?Vote $vote = null): bool
    {
        // nobody can't create/update/delete the mail log
        if (in_array($attribute, [self::CREATE, self::UPDATE, self::DELETE], true)) {
            return false;
        }

        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        if ($this->authorizationChecker->isGranted(UserRole::Supervisor->value)) {
            return true;
        }

        return false;
    }
}
