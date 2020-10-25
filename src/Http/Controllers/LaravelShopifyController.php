<?php

namespace MeinderA\LaravelShopify\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Config\Repository as Config;
use MeinderA\LaravelShopify\Services\LaravelShopifyService;

class LaravelShopifyController extends Controller
{
    protected Config $config;

    protected LaravelShopifyService $laravelShopifyService;

    public function __construct(Config $config, LaravelShopifyService  $laravelShopifyService)
    {
        $this->config = $config;
        $this->laravelShopifyService = $laravelShopifyService;
    }

    public function install(): RedirectResponse
    {
        $approvalUrl = $this->laravelShopifyService->buildApprovalUrl();
        return redirect()->to($approvalUrl);
    }

    /**
     * @throws Exception
     */
    public function generateAccessToken(Request $request)
    {
        $hmacVerified = $this->laravelShopifyService->checkHmac($request->get('hmac'), $request->except(['hmac']));

        if (! $hmacVerified) {
            return response()->json(['result' => 'error', 'message' => 'Could not verify hmac!']);
        }

        $accessToken = $this->laravelShopifyService->getAccessToken($request->get('code'));

        return view('laravel-shopify::show_token', compact(['accessToken']));
    }
}
