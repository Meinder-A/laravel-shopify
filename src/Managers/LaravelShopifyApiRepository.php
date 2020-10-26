<?php

namespace MeinderA\LaravelShopify\Managers;

use MeinderA\LaravelShopify\Managers\Contracts\Driver;

class LaravelShopifyApiRepository
{
    public function __construct(Driver $driver)
    {
        $this->driver = $driver;
    }

    public function allo(string $endpoint, array $params = [], string $method= 'GET', array $headers = []): string
    {
        return $this->driver->allo($endpoint, $params, $method, $headers);
    }

    public function post(string $url, array $params = []): string
    {
        return $this->driver->post($url, $params);
    }
}