<?php

namespace App\Console\Commands;

use App\Events\PriceChanged;
use App\Services\BinanceService;
use App\Services\MessagesService;
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
    public function handle(BinanceService $service, TelegramService $telegramService, MessagesService $messagesService)
    {
        //1. витянути всі унікальні звязки валют з клієнтьсякиї підписок -> ['USD-BTC', 'USD-ETH', 'USD-ADA']
        //2. пробігтись по кожній звязці валют і витянути з Binance API актуальну ціну
        //3. кинути NewPriceEvent

        $updated_id = $messagesService->getLastUpdateId();
        $last_messages = $telegramService->getUpdates($updated_id);

        //create new messages
        $messagesService->createNewMessages($last_messages['result']);

        //get chat ids with subscriptions
        $chat_ids = $messagesService->getChatsWithSubscriptions($this->symbols);

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
