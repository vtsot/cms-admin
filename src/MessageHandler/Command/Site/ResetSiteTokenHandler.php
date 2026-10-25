<?php

declare(strict_types=1);

namespace App\MessageHandler\Command\Site;

use App\Contract\MessageHandler\CommandHandlerInterface;
use App\Exception\Validation\EntityNotFoundException;
use App\Message\Command\Site\ResetSiteTokenCommand;
use App\Repository\Site\SiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

use function bin2hex;
use function random_bytes;
use function sha1;

readonly class ResetSiteTokenHandler implements CommandHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private TranslatorInterface $translator,
        private SiteRepository $siteRepository,
    ) {
    }

    public function __invoke(ResetSiteTokenCommand $command): void
    {
        if (!$site = $this->siteRepository->findOneById($command->siteId)) {
            throw new EntityNotFoundException($this->translator->trans(id: 'SITE.NOT_FOUND', domain: 'validators'));
        }

        // set new token
        $token = sha1(bin2hex(random_bytes(64)));
        $site->setToken($token);

        // save
        $this->em->persist($site);
        $this->em->flush();
    }
}
