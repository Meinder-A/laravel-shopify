<?php

namespace MeinderA\LaravelShopify;

use Illuminate\Support\ServiceProvider;
use MeinderA\LaravelShopify\Services\LaravelShopifyService;
use MeinderA\LaravelShopify\Services\LaravelShopifyApiCallerService;
use MeinderA\LaravelShopify\Http\Middleware\LaravelShopifyInstallationCapture;

class LaravelShopifyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(LaravelShopifyApiCallerService::class, function ($app) {
            return new LaravelShopifyApiCallerService($app['config']);
        });

        $this->app->bind(LaravelShopifyService::class, function ($app) {
            return new LaravelShopifyService($app['config'], $app->make(LaravelShopifyApiCallerService::class));
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
            LaravelShopifyService::class, LaravelShopifyApiCallerService::class,
        ];
    }
}
