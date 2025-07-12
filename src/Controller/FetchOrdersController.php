<?php

namespace App\Controller;

use App\Baselinker\Queue\FetchOrdersMessage;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

readonly class FetchOrdersController
{
    // just to test that the bus is injected correctly, the message can be dispatched, and to check if handler is working

    public function __construct(private MessageBusInterface $bus)
    {
    }

    #[Route('/fetch_orders/{marketplace}', name: 'fetch_orders', methods: ['GET'])]
    public function __invoke(string $marketplace): Response
    {
        try {
            $this->bus->dispatch(new FetchOrdersMessage($marketplace));

            return new JsonResponse([
                'message' => 'Orders fetching initiated',
                'marketplace' => $marketplace,
            ]);
        } catch (\RuntimeException $exception) {
            return new JsonResponse([
                'error' => 'Failed to initiate orders fetching',
                'message' => $exception->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
