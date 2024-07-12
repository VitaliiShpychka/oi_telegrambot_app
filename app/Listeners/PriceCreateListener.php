<?php

namespace App\Listeners;

use App\API\MessageAPI;
use App\API\SmsAPI;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PriceCreateListener
{


    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $API = app(MessageAPI::class);
        $API->sendMessage($event->getMessage(), $event->getPrice());
    }
}
