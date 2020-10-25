<?php

return [
    'shop_name' => env('SHOPIFY_SHOP_NAME'),

    'drivers' => [
        'default' => env('SHOPIFY_DEFAULT_DRIVER'),
        'client' => [
            'key' => env('SHOPIFY_API_KEY'),
            'secret' => env('SHOPIFY_API_SHARED_SECRET_KEY'),
            'scopes' => env('SHOPIFY_API_SCOPES', 'read_products,read_orders'),
        ],
        'mock' => [
            'products' => [
                ['title' => 'Good kush', 'price' => '15.00'],
                ['title' => 'NGC T-Shirt', 'price' => '20.00'],
            ],
            'orders' => [
                ['id' => 00001, 'email' => 'foo@bar.baz'],
                ['id' => 00002, 'email' => 'qux@quux.corge'],
            ],
        ],
    ],

    'install_url' => env('SHOPIFY_INSTALL_URL', 'shopify/install'),
    'generate_access_token' => env('SHOPIFY_GENERATE_ACCESS_TOKEN_URL', 'shopify/store_token'),

    'access_token' => env('SHOPIFY_ACCESS_TOKEN'),
];