<?php

return [
    'shop_name' => env('SHOPIFY_SHOP_NAME'),

    'api_key' => env('SHOPIFY_API_KEY'),
    'shared_secret_key' => env('SHOPIFY_SHARED_SECRET_KEY'),

    'scopes' => env('SHOPIFY_SCOPES', ''),

    'install_url' => env('SHOPIFY_INSTALL_URL', 'shopify/install'),
    'generate_access_token' => env('SHOPIFY_GENERATE_ACCESS_TOKEN_URL', 'shopify/store_token'),

    'access_token' => env('SHOPIFY_ACCESS_TOKEN'),
];