<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <title>Laravel Shopify</title>

    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">

    <style>
        .code {
            font-family: SFMono-Regular, Consolas, Liberation Mono, Menlo, monospace;
            font-size: 85%;

            color: #000;
            margin: 0;
            padding: .2em;
            border-radius: 6px;
            background-color: rgb(27 31 35 / 5%);
        }
    </style>
</head>
<body class="text-center">
<header class="my-4">
    <h1 class="text-5xl mb-3">Laravel Shopify</h1>
    <p class="text-gray-700">You successfully installed and configured Laravel Shopify!</p>

    <div class="absolute top-0 mr-3 mt-3 right-0 flex flex-wrap">
        <a href="https://github.com/meinder-a/laravel-shopify" target="_blank">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
            </svg>
        </a>
    </div>
</header>
<main>
    <h2 class="text-3xl mb-3">Only one step left!</h2>
    <p class="text-gray-700">Put the following line to your <span class="code">.env</span> file, then, clear cache.</p>
    <span class="code">SHOPIFY_ACCESS_TOKEN={{ $accessToken }}</span>
    <hr class="m-6">
    <p class="text-gray-700">Samples:</p>
    <div class="flex justify-center m-3 text-left">
        <div>
            <div class="d-block my-3">
                <span class="block mt-3 mb-1">Getting products <small class="text-muted">(requires <span class="code">read_products</span>)</small></span>
                <pre class="p-3 code">Route::get('products', function () {
    $products = app(\MeinderA\LaravelShopify\Services\LaravelShopifyService::class)->getProducts();
    $products = json_decode($products);

    return response()->json($products);
});</pre>
            </div>
            <div class="d-block my-3">
                <span class="block mt-3 mb-1">Getting orders <small class="text-muted">(requires <span class="code">read_orders</span>)</small></span>
                <pre class="p-3 code">Route::get('orders', function () {
    $orders = app(\MeinderA\LaravelShopify\Services\LaravelShopifyService::class)->getOrders();
    $orders = json_decode($orders);

    return response()->json($orders);
});</pre>
            </div>
        </div>
    </div>
</main>
</body>
</html>
