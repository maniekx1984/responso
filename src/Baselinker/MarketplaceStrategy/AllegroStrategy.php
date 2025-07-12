<?php

namespace App\Baselinker\MarketplaceStrategy;

use App\Baselinker\Service\BaselinkerClientInterface;

readonly class AllegroStrategy implements MarketplaceStrategyInterface
{
    public function __construct(private BaselinkerClientInterface $client)
    {
    }

    public function supports(string $marketplace): bool
    {
        return 'allegro' === $marketplace;
    }

    public function getOrders(): array
    {
        return $this->client->getOrders([
            'date_confirmed_from' => strtotime('-1 day'),
        ]);
    }
}
