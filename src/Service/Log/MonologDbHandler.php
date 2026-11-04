<?php

declare(strict_types=1);

namespace App\Service\Log;

use Carbon\CarbonImmutable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ParameterType;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Level;
use Monolog\LogRecord;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;
use Symfony\Component\DependencyInjection\Attribute\Target;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;
use Throwable;

use function is_string;

/**
 * Writes log records through the dedicated "logger" DBAL connection.
 *
 * It is a separate DB connection (own session), so the INSERT is auto-committed independently of the
 * transaction opened on the default connection (e.g. by the command.bus doctrine_transaction middleware):
 * the log row survives a rollback of the business transaction.
 */
#[AsAlias(id: 'app.monolog.db_handler')]
class MonologDbHandler extends AbstractProcessingHandler
{
    public function __construct(
        #[Target('logger')]
        private readonly Connection $connection,
        private readonly SerializerInterface $serializer,
        int|string|Level $level = Level::Debug,
        bool $bubble = true,
    ) {
        parent::__construct($level, $bubble);
    }

    protected function write(LogRecord $record): void
    {
        $context = $record->context;
        $now     = CarbonImmutable::now();

        try {
            $this->connection->insert('logs', [
                'id'         => Uuid::v7()->toBinary(),
                'created_at' => $now,
                'updated_at' => $now,
                'message'    => $record->message,
                'site_id'    => $this->siteId($context['siteId'] ?? null),
                'method'     => $context['method'] ?? null,
                'url'        => $context['url'] ?? null,
                'headers'    => $this->prepareContext($context['headers'] ?? null),
                'request'    => $this->prepareContext($context['request'] ?? null),
                'response'   => $this->prepareContext($context['response'] ?? null),
                'content'    => $this->prepareContext($context['content'] ?? null),
                'payload'    => $this->prepareContext($context['payload'] ?? null),
            ], [
                'id'         => ParameterType::BINARY,
                'created_at' => 'datetime_immutable',
                'updated_at' => 'datetime_immutable',
                'site_id'    => ParameterType::BINARY,
            ]);
        } catch (Throwable $e) {
            // A failing log write must never break the request that is being logged.
            // error_log(sprintf('DB log write failed: %s', $e->getMessage()));
        }
    }

    private function siteId(mixed $siteId): ?string
    {
        if ($siteId instanceof Uuid) {
            return $siteId->toBinary();
        }

        if (is_string($siteId) && Uuid::isValid($siteId)) {
            return Uuid::fromString($siteId)->toBinary();
        }

        return null;
    }

    private function prepareContext(mixed $context): ?string
    {
        if ($context === null) {
            return null;
        }

        return is_string($context) ? $context : $this->serializer->serialize($context, 'json');
    }
}
