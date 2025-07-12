<?php

namespace App\Baselinker\Service;

interface BaselinkerClientInterface
{
    public function getOrders(array $params = []): array;
}
