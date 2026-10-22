<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use JsonException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

use function is_array;
use function json_decode;

use const JSON_THROW_ON_ERROR;

final readonly class JsonRequestBodyConverter implements EventSubscriberInterface
{
    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();

        if ($request->getContent()
            && ($request->getContentTypeFormat() === 'json'
                || str_starts_with($request->getRequestUri(), '/api/')
            )
        ) {
            try {
                $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

                if (is_array($data)) {
                    $request->request->add($data);
                }
            } catch (JsonException) {
                $event->setResponse(
                    new JsonResponse(
                        [
                            'code'    => Response::HTTP_BAD_REQUEST,
                            'message' => 'Invalid JSON request',
                        ],
                        Response::HTTP_BAD_REQUEST
                    )
                );
            }
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::REQUEST => ['onKernelRequest', 255]];
    }
}
