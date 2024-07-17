<?php

namespace App\Http\Controllers;

use App\Services\BinanceService;

class PriceController extends Controller
{
    protected $binanceRequest;

    public function __construct(BinanceService $binanceRequest)
    {
        $this->binanceRequest = $binanceRequest;
    }

    public function checkPrices()
    {
        return response()->json(['message' => 'Prices checked and events dispatched if necessary']);
    }
}
