<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PriceChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $symbol;
    public $oldPrice;
    public $newPrice;

    public function __construct($symbol, $oldPrice, $newPrice)
    {
        $this->symbol = $symbol;
        $this->oldPrice = $oldPrice;
        $this->newPrice = $newPrice;
    }

}
