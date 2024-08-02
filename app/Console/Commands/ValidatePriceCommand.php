<?php

namespace App\Console\Commands;

use App\Events\PriceChanged;
use App\Services\BinanceService;
use App\Services\MessagesService;
use App\Services\PricesService;
use App\Services\SymbolService;
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

    /**
     * Execute the console command.
     */
    public function handle(BinanceService $service, TelegramService $telegramService, MessagesService $messagesService, PricesService $pricesService)
    {
        //1. витянути всі унікальні звязки валют з клієнтьсякиї підписок -> ['USD-BTC', 'USD-ETH', 'USD-ADA']
        //2. пробігтись по кожній звязці валют і витянути з Binance API актуальну ціну
        //3. кинути NewPriceEvent

        $updated_id = $messagesService->getLastUpdateId() ?? 0;
        $last_messages = $telegramService->getUpdates($updated_id);

        //create new messages
        $messagesService->createNewMessages($last_messages['result']);

        //get chat ids with subscriptions
        $subsriptions = $messagesService->getChatsWithSubscriptions(SymbolService::$SYMBOLS);
        foreach (SymbolService::$SYMBOLS as $symbol){
            $price = $service->getCurrentPrice($symbol);

            $percentage = $pricesService->compareWithLastPrice($symbol, $price);
            $pricesService->savePrice($symbol, $price);

            foreach ($subsriptions as $subsription){
                if($subsription->text == $symbol && abs($percentage) > 0.01){
                    $telegramService->sendMessage($subsription->chat_id, $symbol . ' - ' . $price);
                }
            }
        }
    }
}
