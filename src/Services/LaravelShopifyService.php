<?php

namespace MeinderA\LaravelShopify\Services;

use Exception;
use Illuminate\Config\Repository as Config;

class LaravelShopifyService
{
    protected Config $config;

    protected LaravelShopifyApiCallerService $laravelShopifyApiCaller;

    public function __construct(Config $config, LaravelShopifyApiCallerService $laravelShopifyApiCaller)
    {
        $this->config = $config;
        $this->laravelShopifyApiCaller = $laravelShopifyApiCaller;
    }

    public function buildApprovalUrl(): string
    {
        $shop = $this->config->get('shopify.shop_name');
        $apiKey = $this->config->get('shopify.api_key');
        $scopes = $this->config->get('shopify.scopes');
        $redirectUrl = route('shopify.generate_access_token');

        return "https://$shop.myshopify.com/admin/oauth/authorize?client_id=$apiKey&scope=$scopes&redirect_uri=$redirectUrl";
    }

    public function checkHmac(string $hmac, array $params): bool
    {
        $params = http_build_query($params);
        $sharedSecretKey = $this->config->get('shopify.shared_secret_key');

        $computedHmac = hash_hmac('sha256', $params, $sharedSecretKey);

        return hash_equals($hmac, $computedHmac);
    }

    public function getAccessToken(string $code): string
    {
        $shop = $this->config->get('shopify.shop_name');

        if (! $shop) {
            throw new Exception("Please specify your shop name in your .env");
        }

        $url = 'https://' . $shop . '.myshopify.com/admin/oauth/access_token';
        $params = [
            'client_id' => $this->config->get('shopify.api_key'),
            'client_secret' => $this->config->get('shopify.shared_secret_key'),
            'code' => $code
        ];

        $response = $this->laravelShopifyApiCaller->post($url, $params);
        $response = json_decode($response);

        if ($response->result === "error") {
            throw new Exception($response->message);
        }

        $content = json_decode($response->content);

        if (! isset($content->access_token)) {
            throw new Exception("Unknown response type!");
        }

        return $content->access_token;
    }

    /**
     * @throws Exception
     */
    public function getProducts(): string
    {
        $response = $this->laravelShopifyApiCaller->allo('admin/products.json');
        $response = json_decode($response);

        if ($response->result === "error") {
            throw new Exception($response->message);
        }

        return $response->content;
    }

    /**
     * @throws Exception
     */
    public function getOrders(): string
    {
        $response = $this->laravelShopifyApiCaller->allo('admin/orders.json');
        $response = json_decode($response);

        if ($response->result === "error") {
            throw new Exception($response->message);
        }

        return $response->content;
    }
}
