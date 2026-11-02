<?php

declare(strict_types=1);

namespace App\MessageHandler\Command\Site;

use App\Contract\MessageHandler\CommandHandlerInterface;
use App\Exception\CommunicationException;
use App\Message\Command\Site\SiteCacheClearCommand;
use App\Repository\Site\SiteRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;

use function rtrim;

readonly class SiteCacheClearHandler implements CommandHandlerInterface
{
    public function __construct(
        #[Autowire(service: 'monolog.logger.app.db')]
        private LoggerInterface $logger,
        private HttpClientInterface $httpClient,
        private SiteRepository $siteRepository,
    ) {
    }

    public function __invoke(SiteCacheClearCommand $command): void
    {
        try {
            $response = $this->httpClient->request('POST', '/cache-clear', [
                'base_uri'    => rtrim($command->domain, '/'),
                'verify_peer' => false,
                'headers'     => ['X-API-KEY' => $command->token],
            ]);

            $this->logger->debug('site-cache-clear', [
                'siteId'   => $this->siteRepository->findOneByToken($command->token)?->getId()?->toString(),
                'method'   => 'POST',
                'url'      => rtrim($command->domain, '/') . '/cache-clear',
                'response' => $response->getContent(false),
            ]);
        } catch (Throwable $e) {
            throw CommunicationException::createFromPrevious($e);
        }
    }
}
