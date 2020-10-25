<?php

declare(strict_types=1);

namespace MeinderA\LaravelShopify\Managers\Drivers;

use MeinderA\LaravelShopify\Managers\Contracts\Driver;

class Mock implements Driver
{
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function allo(string $endpoint, array $params = [], string $method = 'GET', array $headers = []): string
    {
        // TODO: Implement allo() method.
    }

    public function post(string $url, array $params = []): string
    {
        // TODO: Implement post() method.
    }

    public function get(string $url, array $params = []): string
    {
        // TODO: Implement get() method.
    }
}