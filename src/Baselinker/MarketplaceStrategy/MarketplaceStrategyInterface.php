<?php

namespace App\Baselinker\MarketplaceStrategy;

interface MarketplaceStrategyInterface
{
    public function supports(string $marketplace): bool;

    public function getOrders(): array;
}
