<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class ExceptionListener
{
    #[AsEventListener]
    public function onExceptionEvent(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof NotFoundHttpException) {
            $event->setResponse(new JsonResponse([
                'error' => 'Resource not found',
            ], 404));
        }        }
}
