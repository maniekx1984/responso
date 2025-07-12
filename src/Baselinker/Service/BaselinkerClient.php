<?php

namespace App\Baselinker\Service;

use App\Baselinker\Exception\BaselinkerApiException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class BaselinkerClient implements BaselinkerClientInterface
{
    public function __construct(
        private HttpClientInterface $client,
        private string $token,
    ) {
    }

    public function getOrders(array $params = []): array
    {
        return $this->request('getOrders', $params);
    }

    private function request(string $method, array $params = []): array
    {
        try {
            $response = $this->client->request('POST', 'https://api.baselinker.com/connector.php', [
                'headers' => ['X-BLToken' => $this->token],
                'body' => [
                    'method' => $method,
                    'parameters' => json_encode($params),
                ],
            ]);

            return $response->toArray();
        } catch (\Exception $e) {
            throw new BaselinkerApiException(sprintf('Baselinker API request failed: %s', $e->getMessage()));
        }
    }
}
