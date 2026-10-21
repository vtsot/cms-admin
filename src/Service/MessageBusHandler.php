<?php

declare(strict_types=1);

namespace App\Service;

use App\Contract\Message\AsyncMessageInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\LogicException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;
use Symfony\Component\Messenger\Stamp\HandledStamp;

use function array_map;
use function count;
use function get_class;
use function implode;
use function sprintf;

class MessageBusHandler
{
    public function __construct(
        private readonly MessageBusInterface $commandBus,
        private readonly MessageBusInterface $queryBus,
        private readonly MessageBusInterface $eventBus,
    ) {
    }

    /**
     * @param object|Envelope $message The message or the message pre-wrapped in an envelope
     */
    public function handleCommand(object $message): mixed
    {
        return $this->getResult(
            $this->commandBus->dispatch($message),
            $message instanceof AsyncMessageInterface
            || ($message instanceof Envelope && count($message->all(DispatchAfterCurrentBusStamp::class)))
        );
    }

    /**
     * @param object|Envelope $message The message or the message pre-wrapped in an envelope
     */
    public function handleQuery(object $message): mixed
    {
        return $this->getResult(
            $this->queryBus->dispatch($message),
            $message instanceof AsyncMessageInterface
            || ($message instanceof Envelope && count($message->all(DispatchAfterCurrentBusStamp::class)))
        );
    }

    /**
     * @param object|Envelope $message The message or the message pre-wrapped in an envelope
     */
    public function handleEvent(object $message): mixed
    {
        return $this->getResult(
            $this->eventBus->dispatch($message),
            true
        );
    }

    private function getResult(Envelope $envelope, bool $allowNoResult = false): mixed
    {
        /** @var HandledStamp[] $handledStamps */
        $handledStamps = $envelope->all(HandledStamp::class);

        if (!$handledStamps) {
            if ($allowNoResult) {
                return null;
            }

            throw new LogicException(
                sprintf(
                    'Message of type "%s" was handled zero times. Exactly one handler is expected when using "%s::%s()".',
                    get_class($envelope->getMessage()),
                    get_class($this),
                    __FUNCTION__
                )
            );
        }

        if (count($handledStamps) > 1) {
            $handlers = implode(
                ', ',
                array_map(
                    static function (HandledStamp $stamp): string {
                        return sprintf('"%s"', $stamp->getHandlerName());
                    },
                    $handledStamps
                )
            );

            throw new LogicException(
                sprintf(
                    'Message of type "%s" was handled multiple times. Only one handler is expected when using "%s::%s()", got %d: %s.',
                    get_class($envelope->getMessage()),
                    get_class($this),
                    __FUNCTION__,
                    count($handledStamps),
                    $handlers
                )
            );
        }

        return $handledStamps[0]->getResult();
    }
}
