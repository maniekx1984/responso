<?php

namespace App\Tests\Mock;

use App\Baselinker\Exception\BaselinkerApiException;
use App\Baselinker\Service\BaselinkerClientInterface;

readonly class MockBaselinkerClient implements BaselinkerClientInterface
{
    public function __construct(
        private string $token,
    ) {
    }

    // use ['throw' => true] in $params to simulate an error
    public function getOrders(array $params = []): array
    {
        return $this->request('getOrders', $params);
    }

    private function request(string $method, array $params = []): array
    {
        if (isset($params['throw']) && $params['throw']) {
            throw new BaselinkerApiException('Simulated error for testing purposes');
        }

        return [
            'status' => 'SUCCESS',
            'orders' => [
                [
                    'order_id' => 1,
                    'marketplace' => 'mock_marketplace',
                    'date_confirmed' => date('Y-m-d H:i:s'),
                    'total_amount' => 100.00,
                ],
                [
                    'order_id' => 2,
                    'marketplace' => 'mock_marketplace',
                    'date_confirmed' => date('Y-m-d H:i:s', strtotime('-1 hour')),
                    'total_amount' => 150.00,
                ],
            ],
        ];
    }
}
