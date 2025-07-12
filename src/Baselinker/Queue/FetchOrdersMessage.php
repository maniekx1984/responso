<?php

namespace App\Baselinker\Queue;

class FetchOrdersMessage
{
    public function __construct(public string $marketplace)
    {
    }
}
