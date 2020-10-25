<?php

use MeinderA\LaravelShopify\Http\Controllers\LaravelShopifyController;

$config = config();

Route::get($config->get('shopify.install_url'), [LaravelShopifyController::class, 'install'])->name('shopify.install');
Route::get($config->get('shopify.generate_access_token'), [LaravelShopifyController::class, 'generateAccessToken'])->name('shopify.generate_access_token');
