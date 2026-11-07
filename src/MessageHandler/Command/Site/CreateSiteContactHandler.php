<?php

declare(strict_types=1);

namespace App\MessageHandler\Command\Site;

use App\Contract\MessageHandler\CommandHandlerInterface;
use App\Entity\Site\Contact;
use App\Exception\Security\AccessDeniedException;
use App\Exception\Validation\EntityNotFoundException;
use App\Exception\Validation\ValidationFailedException;
use App\Message\Command\Site\CreateSiteContactCommand;
use App\Repository\Site\SiteRepository;
use App\Security\Voter\ApiSite\ContactVoter;
use App\Security\Voter\VoterSubject;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Contracts\Translation\TranslatorInterface;

use function array_flip;
use function array_intersect_key;

readonly class CreateSiteContactHandler implements CommandHandlerInterface
{
    public function __construct(
        private Security $security,
        private TranslatorInterface $translator,
        private SiteRepository $siteRepository,
        private EntityManagerInterface $em,
    ) {
    }

    public function __invoke(CreateSiteContactCommand $query): void
    {
        $siteId = $query->user->siteId;
        $token  = $query->user->token;

        if (!$site = $this->siteRepository->findOneActiveBySiteIdAndToken($siteId, $token)) {
            throw new EntityNotFoundException($this->translator->trans(id: 'SITE.NOT_FOUND', domain: 'validators'));
        }

        if (!$this->security->isGranted(ContactVoter::CREATE, new VoterSubject($siteId, Contact::class))) {
            throw new AccessDeniedException($this->translator->trans(id: 'SECURITY.ACCESS_DENIED', domain: 'security'));
        }

        // the $context contains only the fields that are allowed in the fields
        if (!$context = array_intersect_key($query->context ?? [], array_flip($query->fields ?? []))) {
            throw ValidationFailedException::fromArray([[
                'message' => $this->translator->trans(id: 'SITE.CONTACT.CONTEXT_REQUIRED', domain: 'validators'),
                'path'    => 'context',
            ]]);
        }

        $contact = new Contact()
            ->setSite($site)
            ->setContext($context);

        // save
        $this->em->persist($contact);
        $this->em->flush();
    }
}
