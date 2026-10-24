<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\DTO\ErrorDTO;
use App\Exception\AppException;
use App\Exception\Security\AccessDeniedException;
use App\Exception\Validation\EntityNotFoundException;
use App\Exception\Validation\PaymentRequiredException;
use App\Exception\Validation\UnprocessableEntityException;
use App\Exception\Validation\ValidationFailedException;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Exception\ValidationFailedException as SymfonyValidationFailedException;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\Serializer\SerializerInterface;

use function array_key_exists;
use function get_class;
use function in_array;
use function str_contains;

readonly class ApiExceptionToErrorConverter implements EventSubscriberInterface
{
    private const array EXCEPTIONS_TO_CATCH = [
        BadRequestHttpException::class      => Response::HTTP_BAD_REQUEST,
        InvalidOptionsException::class      => Response::HTTP_BAD_REQUEST,
        EntityNotFoundException::class      => Response::HTTP_NOT_FOUND,
        AccessDeniedHttpException::class    => Response::HTTP_FORBIDDEN,
        AccessDeniedException::class        => Response::HTTP_FORBIDDEN,
        UnprocessableEntityException::class => Response::HTTP_UNPROCESSABLE_ENTITY,
        PaymentRequiredException::class     => Response::HTTP_PAYMENT_REQUIRED,
        AppException::class                 => Response::HTTP_BAD_REQUEST,
        TooManyRequestsHttpException::class => Response::HTTP_TOO_MANY_REQUESTS,
    ];

    private const array EXCEPTIONS_TO_NORMALIZE = [
        ValidationFailedException::class        => Response::HTTP_UNPROCESSABLE_ENTITY,
        SymfonyValidationFailedException::class => Response::HTTP_UNPROCESSABLE_ENTITY,
    ];

    public function __construct(
        private SerializerInterface $serializer,
        #[Autowire(param: 'api_domain')]
        private string $apiDomain,
    ) {
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $request = $event->getRequest();

        if (!($request->getContentTypeFormat() === 'json'
            || in_array('application/json', $request->getAcceptableContentTypes(), true)
            || $request->getHost() === $this->apiDomain
            || str_contains($request->getPathInfo(), '/api/'))
        ) {
            return;
        }

        $throwable = $event->getThrowable();

        while ($throwable instanceof HandlerFailedException) {
            $throwable = $throwable->getPrevious();
        }

        $throwableClass = get_class($throwable);

        if (array_key_exists($throwableClass, self::EXCEPTIONS_TO_NORMALIZE)) {
            $errorCode = self::EXCEPTIONS_TO_NORMALIZE[$throwableClass];

            $event->setResponse(
                new JsonResponse(
                    $this->serializer->serialize($throwable, 'json'),
                    $errorCode,
                    [],
                    true
                )
            );
        } elseif (array_key_exists($throwableClass, self::EXCEPTIONS_TO_CATCH)
            || $throwable instanceof AppException
        ) {
            $errorCode = self::EXCEPTIONS_TO_CATCH[$throwableClass] ?? Response::HTTP_BAD_REQUEST;

            $event->setResponse(
                new JsonResponse(
                    $this->serializer->serialize(new ErrorDTO($errorCode, $throwable->getMessage()), 'json'),
                    $errorCode,
                    [],
                    true
                )
            );
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
}
