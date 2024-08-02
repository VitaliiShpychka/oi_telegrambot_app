<?php

namespace App\Services;

use App\Models\Price;

class PricesService
{
    public function savePrice(string $symbol, float $price): void
    {
        $price_object = new Price();
        $price_object->price = $price;
        $price_object->symbol = $symbol;
        $price_object->save();
    }

    public function compareWithLastPrice(string $symbol, float $price_new): float
    {
        $price_old = Price::where('symbol', $symbol)->latest()->first();

        return number_format(bcdiv(bcsub($price_new, $price_old->price, 5), $price_old->price, 5), 5 , '.', '');
    }
}
