<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class BinanceRequest
{
    protected $user;
    protected $binanceApiUrl = 'https://api.binance.com/api/v3/ticker/price?symbol=';

    public function __construct()
    {
        $this->user = new User();
    }

    public function getCoinPrices(array $coins)
    {
        $prices = [];

        foreach ($coins as $coin) {
            $response = $this->user->get($this->binanceApiUrl . $coin);
            $data = json_decode($response->getBody(), true);
            $prices[$coin] = $data['price'];
        }

        return $prices;
    }
}
