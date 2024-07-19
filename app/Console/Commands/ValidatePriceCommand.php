<?php

namespace App\Console\Commands;

use App\Services\BinanceService;
use App\Services\TelegramService;
use Illuminate\Console\Command;
use Ramsey\Collection\Collection;

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

    private $keyboard = [
        [
            ["text" => "BTCUSDT"],
            ["text" => "ETHUSDT"]
        ],
        [
            ["text" => "BNBUSDT"],
            ["text" => "BTCUSDT"]
        ]
    ];

    /**
     * Execute the console command.
     */
    public function handle(BinanceService $service, TelegramService $telegramService)
    {
        //1. витянути всі унікальні звязки валют з клієнтьсякиї підписок -> ['USD-BTC', 'USD-ETH', 'USD-ADA']
        //2. пробігтись по кожній звязці валют і витянути з Binance API актуальну ціну
        //3. кинути NewPriceEvent

        $replyMarkup = json_encode([
            "keyboard" => $this->keyboard,
            "resize_keyboard" => true,
            "one_time_keyboard" => true
        ]);

        $last_messages = $telegramService->getUpdates();
        $sorted_data = collect($last_messages['result'])->sortByDesc('message.date')->toArray();

        $chat_ids = [];
        $send_button = [];
        foreach ($sorted_data as $message) {
            if(!in_array($message['message']['chat']['id'], $chat_ids) && !in_array($message['message']['chat']['id'], $send_button)) {
                if ($message['message']['text'] === '/start' || $message['message']['text'] === '/menu') {
                    $send_button[] = $message['message']['chat']['id'];
                    $telegramService->sendMessageWithButtons(
                        $message['message']['chat']['id'],
                        'Choose currency:',
                        $replyMarkup
                    );
                } else {
                    $telegramService->sendMessage($message['message']['chat']['id'], $service->getCurrentPrice($message['message']['text']));
                    $chat_ids[] = $message['message']['chat']['id'];
                }
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
