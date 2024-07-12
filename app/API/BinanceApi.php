<?php

namespace App\API;

use GuzzleHttp\Client;

class BinanceApi
{
    private $client;
    private $apiKey;
    private $secretKey;
    private $baseUrl = 'https://api.binance.com/api/v3/';

    public function __construct($apiKey, $secretKey)
    {
        $this->apiKey = env('BINANCE_API_KEY');
        $this->secretKey = env('BINANCE_API_SYCRET_KEY');

        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'X-MBX-APIKEY' => $this->apiKey
            ]
        ]);
    }

    public function getCurrentPrice($symbol)
    {
        try {
            $response = $this->client->request('GET', 'ticker/price', [
                'query' => ['symbol' => $symbol]
            ]);

            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getBody(), true);
                return $data['price'];
            }
        } catch (\Exception $e) {
            // Обробка помилок
            return 'Error: ' . $e->getMessage();
        }

        return null;
    }
}
