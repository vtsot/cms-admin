<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Log;
use App\Entity\Site\Site;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Level;
use Monolog\LogRecord;
use Symfony\Component\Uid\Uuid;

use function is_string;

class MonologDbHandler extends AbstractProcessingHandler
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        int|string|Level $level = Level::Debug,
        bool $bubble = true,
    ) {
        parent::__construct($level, $bubble);
    }

    /**
     * @throws ORMException
     */
    protected function write(LogRecord $record): void
    {
        $log = new Log()
            ->setMessage($record->message);

        if ($siteId = ($record->context['siteId'] ?? null)) {
            if ($siteId instanceof Uuid) {
                $log->setSite($this->em->getReference(Site::class, $siteId));
            }

            if (is_string($siteId) && Uuid::isValid($siteId)) {
                $log->setSite($this->em->getReference(Site::class, Uuid::fromString($siteId)));
            }
        }

        if ($record->context['method'] ?? null) {
            $log->setMethod($record->context['method']);
        }

        if ($record->context['url'] ?? null) {
            $log->setUrl($record->context['url']);
        }

        if ($record->context['request'] ?? null) {
            $log->setRequest($record->context['request']);
        }

        if ($record->context['response'] ?? null) {
            $log->setResponse($record->context['response']);
        }

        if ($record->context['content'] ?? null) {
            $log->setContent($record->context['content']);
        }

        if ($record->context['entryId'] ?? null) {
            $log->setEntryId($record->context['entryId']);
        }

        if ($record->context['payload'] ?? null) {
            $log->setPayload($record->context['payload']);
        }

        $this->em->persist($log);
        $this->em->flush();
    }
}
