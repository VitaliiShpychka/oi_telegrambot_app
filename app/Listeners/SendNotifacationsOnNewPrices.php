<?php

namespace App\Listeners;

use App\API\MessageAPI;
use App\API\SmsAPI;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNotifacationsOnNewPrices
{


    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        // 1. Витягуємо всі клієнські підписки
        // 2. Біжимо по всім підпискам і перевіряємо чи хтось уже очікує оновлення ціни
        // якщо last_send_notification_date + interval (наприклад 10 хв) < now
        // але якщо різниця не більше 1% в + чи в - від попередньої ціни ми не надсилаємо повідомлення
        // але в кожному випадку оновлюємо last_send_notification_date

        //        $API = app(MessageAPI::class);
        //        $API->sendMessage($event->getMessage(), $event->getPrice());
    }
}
