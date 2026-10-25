<?php

declare(strict_types=1);

namespace App\MessageHandler\Command\Site;

use App\Contract\MessageHandler\CommandHandlerInterface;
use App\Exception\Validation\UnprocessableEntityException;
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
        throw new UnprocessableEntityException('Not implemented');
        //        if (!$this->security->isGranted(ContactVoter::VIEW, new VoterSubject($query->siteId, Contact::class))) {
        //            throw new AccessDeniedException($this->translator->trans(id: 'SECURITY.ACCESS_DENIED', domain: 'security'));
        //        }
    }
}
