<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class sendBinanceRequest extends FormRequest
{


    public function rules(): array
    {
        return [
            'price' => 'required|numeric',
            'qty' => 'required|numeric',
            'time' => 'required|date',
            'isBuyerMarket' => 'required|boolean',
        ];
    }
}
