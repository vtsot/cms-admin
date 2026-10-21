<?php

declare(strict_types=1);

namespace App\Command\Site;

use App\CQ\Command\Site\Email\SendSiteDomainExpireEmailCommand;
use App\Entity\EmailTemplate;
use App\Repository\Site\SiteRepository;
use App\Service\MessageBusHandler;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use function count;

#[AsCommand(
    name: 'app:site-domain-expire:email-send',
    description: 'Send site domain expire emails',
)]
class SiteDomainExpireEmailSendCommand extends Command
{
    public function __construct(
        private readonly SiteRepository $siteRepository,
        private readonly MessageBusHandler $messageBusHandler,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $verbose = $input->getOption('verbose');

        // collect sites to send
        $siteIdsExpireAt4Weeks = $this->siteRepository->findAllActiveSiteIdsWhereExpireAt4WeeksBefore();
        $siteIdsExpireAt2Weeks = $this->siteRepository->findAllActiveSiteIdsWhereExpireAt2WeeksBefore();
        $siteIdsExpireAt1Day   = $this->siteRepository->findAllActiveSiteIdsWhereExpireAt1DayBefore();

        // inits
        $total    = count($siteIdsExpireAt4Weeks) + count($siteIdsExpireAt2Weeks) + count($siteIdsExpireAt1Day);
        $io       = null;
        $progress = null;

        if ($verbose) {
            $io = new SymfonyStyle($input, $output);
            $io->title('Sending emails for expired site domains');
            $progress = new ProgressBar($io, $total);
        }

        // handle case when nothing to send
        if ($total === 0) {
            $io?->comment('Nothing to send');

            return self::SUCCESS;
        }

        // send
        $this->handleSendSiteDomainExpireEmail($progress, $siteIdsExpireAt4Weeks, EmailTemplate::CODE_EXPIRATION_4_WEEKS_BEFORE);
        $this->handleSendSiteDomainExpireEmail($progress, $siteIdsExpireAt2Weeks, EmailTemplate::CODE_EXPIRATION_2_WEEKS_BEFORE);
        $this->handleSendSiteDomainExpireEmail($progress, $siteIdsExpireAt1Day, EmailTemplate::CODE_EXPIRATION_1_DAY_BEFORE);

        // done
        $io?->info('Done');

        return self::SUCCESS;
    }

    /**
     * @param array<int, string> $siteIds
     */
    private function handleSendSiteDomainExpireEmail(?ProgressBar $progress, array $siteIds, string $template): void
    {
        foreach ($siteIds as $siteId) {
            $this->messageBusHandler->handleCommand(
                new SendSiteDomainExpireEmailCommand(
                    Uuid::fromString($siteId),
                    $template
                )
            );

            $progress?->advance();
        }
    }
}
