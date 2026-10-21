<?php

declare(strict_types=1);

namespace App\CQ\Command\Site;

use App\Contract\MessageHandler\CommandHandlerInterface;
use App\Exception\CommunicationException;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;

use function rtrim;

readonly class SiteCacheClearHandler implements CommandHandlerInterface
{
    public function __construct(
        private HttpClientInterface $httpClient,
    ) {
    }

    public function __invoke(SiteCacheClearCommand $command): void
    {
        try {
            $this->httpClient->request('POST', '/cache-clear', [
                'base_uri'    => rtrim($command->domain, '/'),
                'verify_peer' => false,
                'headers'     => ['X-API-KEY' => $command->token],
            ]);
        } catch (Throwable $e) {
            throw CommunicationException::createFromPrevious($e);
        }
    }
}
