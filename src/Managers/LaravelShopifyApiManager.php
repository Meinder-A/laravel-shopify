<?php

namespace MeinderA\LaravelShopify\Managers;

use DeGraciaMathieu\Manager\Manager;
use Illuminate\Config\Repository as Config;
use MeinderA\LaravelShopify\Managers\Contracts\Driver;

class LaravelShopifyApiManager extends Manager
{
    protected Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function createClientDriver(): LaravelShopifyApiRepository
    {
        $config = $this->config->get('shopify');

        $driver = new Drivers\Client($config);

        return $this->getRepository($driver);
    }

    public function createMockDriver(): LaravelShopifyApiRepository
    {
        $config = $this->config->get('shopify');

        $driver = new Drivers\Mock($config);

        return $this->getRepository($driver);
    }

    protected function getRepository(Driver $driver): LaravelShopifyApiRepository
    {
        return new LaravelShopifyApiRepository($driver);
    }

    public function getDefaultDriver(): string
    {
        return $this->config->get('shopify.drivers.default');
    }
}