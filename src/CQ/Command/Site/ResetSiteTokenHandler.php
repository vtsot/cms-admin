<?php

declare(strict_types=1);

namespace App\CQ\Command\Site;

use App\Contract\MessageHandler\CommandHandlerInterface;
use App\Exception\Validation\EntityNotFoundException;
use App\Repository\Site\SiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

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
        $site = $this->siteRepository->findOneById($command->siteId);

        if ($site === null) {
            throw new EntityNotFoundException($this->translator->trans('SITE.NOT_FOUND'));
        }

        // set new token
        $token = sha1(bin2hex(random_bytes(64)));
        $site->setToken($token);

        // save
        $this->em->persist($site);
        $this->em->flush();
    }
}
