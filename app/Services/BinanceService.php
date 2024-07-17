<?php

namespace App\Services;

use GuzzleHttp\Client;

class BinanceService
{
    private $client;
    private $baseUrl = 'https://api.binance.com/api/v3/';

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
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
            return 'Error: ' . $e->getMessage();
        }

        return null;
    }
}
