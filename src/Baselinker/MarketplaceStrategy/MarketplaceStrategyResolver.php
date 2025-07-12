<?php

namespace App\Baselinker\MarketplaceStrategy;

use App\Baselinker\Exception\MarketplaceStrategyException;

readonly class MarketplaceStrategyResolver
{
    public function __construct(private iterable $strategies)
    {
    }

    public function resolve(string $marketplace): MarketplaceStrategyInterface
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy->supports($marketplace)) {
                return $strategy;
            }
        }

        throw new MarketplaceStrategyException(sprintf('No strategy found for marketplace: %s', $marketplace));
    }
}
