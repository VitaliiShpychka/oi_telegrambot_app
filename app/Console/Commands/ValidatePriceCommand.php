<?php

namespace App\Console\Commands;

use App\Events\PriceChanged;
use App\Services\BinanceService;
use App\Services\TelegramService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ValidatePriceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:validate-price-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $symbols = ['BTCUSDT', 'ETHUSDT', 'BNBUSDT'];

    /**
     * Execute the console command.
     */
    public function handle(BinanceService $service, TelegramService $telegramService)
    {
        //1. витянути всі унікальні звязки валют з клієнтьсякиї підписок -> ['USD-BTC', 'USD-ETH', 'USD-ADA']
        //2. пробігтись по кожній звязці валют і витянути з Binance API актуальну ціну
        //3. кинути NewPriceEvent

        $last_messages = $telegramService->getUpdates();
        print_r($last_messages);

        $chat_ids = [];
        foreach ($last_messages['result'] as $message) {
            if(!in_array($message['message']['chat']['id'], $chat_ids)){
                $chat_ids[] = $message['message']['chat']['id'];
            }
        }

        foreach ($this->symbols as $symbol){
            $price = $service->getCurrentPrice($symbol);
            foreach ($chat_ids as $chat_id){
                $telegramService->sendMessage($chat_id, $symbol . ' - ' . $price);
            }
        }

//        foreach ($prices as $symbol => $newPrice) {
//            $oldPrice = Cache::get($symbol);
//
//            if ($oldPrice && abs(($newPrice - $oldPrice) / $oldPrice) >= 0.05) {
//                event(new PriceChanged($symbol, $oldPrice, $newPrice));
//            }
//
//            Cache::put($symbol, $newPrice, now()->addMinutes(5));
//        }
    }

}
