<?php

namespace MeinderA\LaravelShopify\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LaravelShopifyInstallationCapture
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->filled(['hmac', 'shop'])) {
            return redirect(route('shopify.install'));
        }

        return $next($request);
    }
}