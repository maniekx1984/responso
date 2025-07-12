<?php

namespace App\Baselinker\Service;

use App\Baselinker\Exception\BaselinkerApiException;
use Monolog\Attribute\WithMonologChannel;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Stopwatch\Stopwatch;

#[WithMonologChannel('baselinker')]
readonly class BaselinkerClient implements BaselinkerClientInterface
{
    public function __construct(
        private HttpClientInterface $client,
        private Stopwatch $stopwatch,
        private LoggerInterface $logger,
        private string $token,
    ) {
    }

    public function getOrders(array $params = []): array
    {
        $stopwatchName = 'Baselinker.getOrders';
        $this->stopwatch->start($stopwatchName);
        return $this->request('getOrders', $stopwatchName, $params);
    }

    private function request(string $method, string $stopwatchName, array $params = []): array
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
        } finally {
            $event = $this->stopwatch->stop($stopwatchName);
            $this->logger->info('Baselinker API request completed', [
                'method' => $method,
                'duration' => $event->getDuration(),
                'memory' => $event->getMemory(),
                'params' => $params,
            ]);
        }
    }
}
