<?php

declare(strict_types=1);

namespace App\Service\Log;

use BadMethodCallException;
use Psr\Log\LoggerInterface;
use Stringable;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;

use function call_user_func_array;
use function method_exists;
use function sprintf;

/**
 * @method void emergency(Stringable|string $message, array $context = [])
 * @method void alert(Stringable|string $message, array $context = [])
 * @method void critical(Stringable|string $message, array $context = [])
 * @method void error(Stringable|string $message, array $context = [])
 * @method void warning(Stringable|string $message, array $context = [])
 * @method void notice(Stringable|string $message, array $context = [])
 * @method void info(Stringable|string $message, array $context = [])
 * @method void debug(Stringable|string $message, array $context = [])
 * @method void log($level, Stringable|string $message, array $context = [])
 */
readonly class AppLogger
{
    public const string CONTEXT_SITE_ID  = 'site_id';
    public const string CONTEXT_METHOD   = 'method';
    public const string CONTEXT_URL      = 'url';
    public const string CONTEXT_REQUEST  = 'request';
    public const string CONTEXT_HEADERS  = 'headers';
    public const string CONTEXT_RESPONSE = 'response';
    public const string CONTEXT_CONTENT  = 'content';
    public const string CONTEXT_PAYLOAD  = 'payload';

    public function __construct(
        #[Autowire(service: 'monolog.logger.app.db')]
        private LoggerInterface $logger,
    ) {
    }

    public function __call(string $name, array $arguments)
    {
        if (method_exists($this->logger, $name)) {
            return call_user_func_array([$this->logger, $name], $arguments);
        }

        throw new BadMethodCallException(sprintf('Method "%s" is not defined in "%s"', $name, static::class));
    }

    public static function contextFromRequest(Request $request, array $context = []): array
    {
        return [
            'siteId'   => $context[self::CONTEXT_SITE_ID] ?? $context['siteId'] ?? null,
            'method'   => $context[self::CONTEXT_METHOD] ?? $request->getMethod(),
            'url'      => $context[self::CONTEXT_URL] ?? $request->getRequestUri(),
            'request'  => $context[self::CONTEXT_REQUEST] ?? null,
            'headers'  => $context[self::CONTEXT_HEADERS] ?? null,
            'response' => $context[self::CONTEXT_RESPONSE] ?? null,
            'content'  => $context[self::CONTEXT_CONTENT] ?? null,
            'payload'  => $context[self::CONTEXT_PAYLOAD] ?? null,
        ];
    }
}
