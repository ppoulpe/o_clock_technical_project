<?php

declare(strict_types=1);

namespace App\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(ExceptionEvent $exceptionEvent): void
    {
        $exception = $exceptionEvent->getThrowable();
        $response = new JsonResponse(
            [
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ]
        );

        switch (true) {
            case $exception instanceof HttpExceptionInterface:
                $response->setStatusCode($exception->getStatusCode());
                $response->headers->replace($exception->getHeaders());
                break;
            default:
                $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
                break;
        }

        $exceptionEvent->setResponse($response);
    }
}
