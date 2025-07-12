<?php

namespace App\Tests\Baselinker\MarketplaceStrategy;

use App\Baselinker\MarketplaceStrategy\AllegroStrategy;
use App\Baselinker\Service\BaselinkerClient;
use PHPUnit\Framework\TestCase;

class AllegroStrategyTest extends TestCase
{
    public function testGetOrdersReturnsArray()
    {
        $client = $this->createMock(BaselinkerClient::class);
        $client->method('getOrders')->willReturn(['orders' => []]);

        $strategy = new AllegroStrategy($client);
        $this->assertTrue($strategy->supports('allegro'));

        $orders = $strategy->getOrders();
        $this->assertIsArray($orders);
    }
}
