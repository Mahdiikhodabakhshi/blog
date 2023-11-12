<?php
namespace App\EventListener;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class NotFoundListener implements EventSubscriberInterface
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        // Check if the exception is a ResourceNotFoundException
        if ($exception instanceof NotFoundHttpException) {
            // Redirect to your desired URL
            $response = new RedirectResponse('/restaurante');
            
            // Set the response on the event
            $event->setResponse($response);
           
        }
    }

    public static function getSubscribedEvents()
    {
        // Subscribe to the kernel.exception event
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
}
