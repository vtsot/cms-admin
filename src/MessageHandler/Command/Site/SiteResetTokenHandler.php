<?php

declare(strict_types=1);

namespace App\MessageHandler\Command\Site;

use App\Contract\MessageHandler\CommandHandlerInterface;
use App\Exception\Validation\EntityNotFoundException;
use App\Message\Command\Site\SiteResetTokenCommand;
use App\Repository\Site\SiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\Translation\TranslatorInterface;

use function bin2hex;
use function random_bytes;
use function sha1;

use const PHP_EOL;

readonly class SiteResetTokenHandler implements CommandHandlerInterface
{
    public function __construct(
        #[Autowire(service: 'monolog.logger.app.db')]
        private LoggerInterface $logger,
        private EntityManagerInterface $em,
        private TranslatorInterface $translator,
        private SiteRepository $siteRepository,
    ) {
    }

    public function __invoke(SiteResetTokenCommand $command): void
    {
        if (!$site = $this->siteRepository->findOneById($command->siteId)) {
            throw new EntityNotFoundException($this->translator->trans(id: 'SITE.NOT_FOUND', domain: 'validators'));
        }

        // set new token
        $oldToken = $site->getToken();
        $token    = sha1(bin2hex(random_bytes(64)));
        $site->setToken($token);

        // save
        $this->em->persist($site);
        $this->em->flush();

        $this->logger->debug('site-reset-token', [
            'siteId'  => $site->getId(),
            'content' => '<strong>Old Token:</strong> ' . $oldToken . PHP_EOL . '<strong>New Token:</strong> ' . $token,
        ]);
    }
}
