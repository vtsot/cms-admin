<?php

declare(strict_types=1);

namespace App\MessageHandler\Command\Site;

use App\Contract\MessageHandler\CommandHandlerInterface;
use App\Message\Command\Site\CreateContactCommand;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class CreateContactHandler implements CommandHandlerInterface
{
    public function __construct(
        private Security $security,
        private TranslatorInterface $translator,
    ) {
    }

    public function __invoke(CreateContactCommand $query): void
    {
        //        if (!$banner = $this->resolveRandomBanner($query)) {
        //            throw new EntityNotFoundException($this->translator->trans(id: 'GENERAL.NOT_FOUND', domain: 'validators'));
        //        }
        //
        //        if (!$this->security->isGranted(BannerVoter::VIEW, new VoterSubject($query->siteId, $banner))) {
        //            throw new AccessDeniedException($this->translator->trans(id: 'SECURITY.ACCESS_DENIED', domain: 'security'));
        //        }
    }
}
