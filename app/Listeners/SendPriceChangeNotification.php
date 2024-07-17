<?php

namespace App\Listeners;

use App\API\MessageAPI;
use App\Events\PriceChanged;
use App\Http\Responses\TelegramResponse;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPriceChangeNotification
{


    /**
     * Handle the event.
     */

        // 1. Витягуємо всі клієнські підписки
        // 2. Біжимо по всім підпискам і перевіряємо чи хтось уже очікує оновлення ціни
        // якщо last_send_notification_date + interval (наприклад 10 хв) < now
        // але якщо різниця не більше 1% в + чи в - від попередньої ціни ми не надсилаємо повідомлення
        // але в кожному випадку оновлюємо last_send_notification_date

        //        $API = app(MessageAPI::class);
        //        $API->sendMessage($event->getMessage(), $event->getPrice());

    protected $telegramResponse;

    public function __construct(TelegramResponse $telegramResponse)
    {
        $this->telegramResponse = $telegramResponse;
    }

    public function handle(PriceChanged $event)
    {
        $percentageChange = (($event->newPrice - $event->oldPrice) / $event->oldPrice) * 100;
        $message = "Ціна {$event->symbol} змінилася на {$percentageChange}% і тепер становить \${$event->newPrice}.";

        // Відправка повідомлення в Telegram
        $this->telegramResponse->sendMessage(env('TELEGRAM_CHAT_ID'), $message);
    }
}
