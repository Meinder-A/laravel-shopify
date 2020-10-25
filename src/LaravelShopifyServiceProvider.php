<?php

declare(strict_types=1);

namespace MeinderA\LaravelShopify;

use Illuminate\Support\ServiceProvider;
use MeinderA\LaravelShopify\Services\LaravelShopifyService;
use MeinderA\LaravelShopify\Managers\LaravelShopifyApiManager;
use MeinderA\LaravelShopify\Http\Middleware\LaravelShopifyInstallationCapture;

class LaravelShopifyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(LaravelShopifyService::class, function ($app) {
            return new LaravelShopifyService($app['config'], $app->make(LaravelShopifyApiManager::class));
        });
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/views/', 'laravel-shopify');
        $this->publishes([__DIR__ . '/config/shopify.php' => config_path('shopify.php')], 'laravel-shopify/config');

        $router = $this->app['router'];
        $router->pushMiddlewareToGroup('web', LaravelShopifyInstallationCapture::class);
    }

    public function provides()
    {
        return [
            LaravelShopifyService::class, LaravelShopifyApiManager::class,
        ];
    }
}
