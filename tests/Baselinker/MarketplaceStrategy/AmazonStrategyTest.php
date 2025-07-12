<?php

namespace App\Tests\Baselinker\MarketplaceStrategy;

use App\Baselinker\MarketplaceStrategy\AmazonStrategy;
use App\Baselinker\Service\BaselinkerClient;
use PHPUnit\Framework\TestCase;

class AmazonStrategyTest extends TestCase
{
    public function testGetOrdersReturnsArray()
    {
        $client = $this->createMock(BaselinkerClient::class);
        $client->method('getOrders')->willReturn(['orders' => []]);

        $strategy = new AmazonStrategy($client);
        $this->assertTrue($strategy->supports('amazon'));

        $orders = $strategy->getOrders();
        $this->assertIsArray($orders);
    }
}
