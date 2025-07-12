<?php

namespace App\Baselinker\Handler;

use App\Baselinker\MarketplaceStrategy\MarketplaceStrategyResolver;
use App\Baselinker\Queue\FetchOrdersMessage;
use JetBrains\PhpStorm\NoReturn;
use Monolog\Attribute\WithMonologChannel;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
#[WithMonologChannel('baselinker')]
readonly class FetchOrdersHandler
{
    public function __construct(
        private MarketplaceStrategyResolver $resolver,
        private LoggerInterface $logger,
    ) {
    }

    #[NoReturn]
    public function __invoke(FetchOrdersMessage $message): void
    {
        try {
            $strategy = $this->resolver->resolve($message->marketplace);
            $orders = $strategy->getOrders();

            $this->logger->info('Orders fetched', [
                'marketplace' => $message->marketplace,
                'orders' => $orders,
            ]);

            // TODO: Process the fetched orders
        } catch (\Throwable $e) {
            $this->logger->error('Error while fetching orders', [
                'marketplace' => $message->marketplace,
                'exception' => $e->getMessage(),
            ]);
        }
    }
}
