<?php

namespace MeinderA\LaravelShopify\Managers\Drivers;

use Exception;
use MeinderA\LaravelShopify\Managers\Contracts\Driver;

class Client implements Driver
{
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @throws Exception
     */
    public function allo(string $endpoint, array $params = [], string $method = 'GET', array $headers = []): string
    {
        if (! isset($this->config['access_token'])) {
            throw new Exception("Access token has not been initialized!");
        }

        $token = $this->config['access_token'];

        $shopName = $this->config->get('shopify.shop_name');
        $urlEndpoint = "https://$shopName.myshopify.com/$endpoint";

        return $this->request($method, $urlEndpoint, $params, $token);
    }

    protected function request(string $method, string $uri, array $params = [], string $token = null): string
    {
        if (! is_null($params) && in_array($method, ['GET', 'DELETE'])) {
            $builtQuery = http_build_query($params);
            $urlEndpoint = "$uri?/$builtQuery";
        }

        $curl = curl_init($urlEndpoint);
        curl_setopt($curl, CURLOPT_HEADER, TRUE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 3);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_USERAGENT, 'meinder-a/laravel-shopify');
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

        if (! is_null($token)) {
            $headers[] = "X-Shopify-Access-Token: $token";
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers ?? []);

        if ($method != 'GET' && in_array($method, array('POST', 'PUT'))) {
            if (is_array($params)) {
                $params = http_build_query($params);
            }
            curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        }

        return $this->execCurl($curl);
    }

    public function post(string $url, array $params = []): string
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, count($params));
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));

        return $this->execCurl($curl);
    }

    public function get(string $url, array $params = []): string
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));

        return $this->execCurl($curl);
    }

    protected function execCurl(&$curl): string
    {
        $response = curl_exec($curl);
        $errorNumber = curl_errno($curl);
        $errorMessage = curl_error($curl);
        curl_close($curl);

        if ($errorNumber) {
            return json_encode([
                'result' => 'error',
                'message' => $errorMessage,
            ]);
        }

        return $this->format($response);
    }

    protected function format(string $response): string
    {
        preg_match('/(.*)\r\n\r\n(.*)/ms', $response, $matches);

        if (count($matches) !== 3) {
            return json_encode([
                'result' => 'ok',
                'content' => $response,
            ]);
        }

        return json_encode([
            'result' => 'ok',
            'headers' => $matches[1],
            'content' => $matches[2],
        ]);
    }
}