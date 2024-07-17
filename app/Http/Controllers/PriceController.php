<?php

namespace App\Http\Controllers;

use App\Events\PriceChanged;
use App\Http\Requests\BinanceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PriceController extends Controller
{
    protected $binanceRequest;

    public function __construct(BinanceRequest $binanceRequest)
    {
        $this->binanceRequest = $binanceRequest;
    }

    public function checkPrices()
    {
        $symbols = ['BTCUSDT', 'ETHUSDT', 'BNBUSDT'];
        $prices = $this->binanceRequest->getCoinPrices($symbols);

        foreach ($prices as $symbol => $newPrice) {
            $oldPrice = Cache::get($symbol);

            if ($oldPrice && abs(($newPrice - $oldPrice) / $oldPrice) >= 0.05) {
                event(new PriceChanged($symbol, $oldPrice, $newPrice));
            }

            Cache::put($symbol, $newPrice, now()->addMinutes(5));
        }

        return response()->json(['message' => 'Prices checked and events dispatched if necessary']);
    }
}
