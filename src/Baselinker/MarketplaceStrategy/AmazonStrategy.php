<?php

namespace App\Baselinker\MarketplaceStrategy;

use App\Baselinker\Service\BaselinkerClient;

readonly class AmazonStrategy implements MarketplaceStrategyInterface
{
    public function __construct(private BaselinkerClient $client)
    {
    }

    public function supports(string $marketplace): bool
    {
        return 'amazon' === $marketplace;
    }

    public function getOrders(): array
    {
        return $this->client->getOrders([
            'date_confirmed_from' => strtotime('-12 hours'),
        ]);
    }
}
