<?php

declare(strict_types=1);

namespace MeinderA\LaravelShopify\Managers\Contracts;

interface Driver
{
    public function allo(string $endpoint, array $params = [], string $method= 'GET', array $headers = []): string;

    public function post(string $url, array $params = []): string;

    public function get(string $url, array $params = []): string;
}