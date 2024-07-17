<?php

namespace App\Http\Responses;

use App\Models\Symbol;
use App\Models\User;
use Illuminate\Contracts\Support\Responsable;

class TelegramResponse implements Responsable
{
//    public User $user;
//    public Symbol $symbol;
//    public function __construct(Symbol $symbol, User $user)
//    {
//        $this->user = $user;
//        $this->symbol = $symbol;
//    }
//    public function toResponse($request): array
//    {
//        return[
//            'price_start' =>$this->symbol->price_start,
//            'price_last'=> $this->user->price_last,
//            'time'=>$this->symbol->time
//        ];
//    }

    protected $user;
    protected $telegramApiUrl;

    public function __construct()
    {
        $this->user = new User();
        $this->telegramApiUrl = 'https://api.telegram.org/bot' . env('TELEGRAM_BOT_TOKEN') . '/';
    }

    public function sendMessage($chatId, $text): void
    {
        $this->user->post($this->telegramApiUrl . 'sendMessage', [
            'json' => [
                'chat_id' => $chatId,
                'text' => $text
            ]
        ]);
    }

    public function formatPrices(array $prices): string
    {
        $responseText = "Ціни на криптовалюти:\n";
        foreach ($prices as $coin => $price) {
            $responseText .= "{$coin}: \${$price}\n";
        }

        return $responseText;
    }
    public function getInlineKeyboard()
    {
        return [
            'inline_keyboard' => [
                [
                    ['text' => 'BTC', 'callback_data' => 'BTCUSDT'],
                    ['text' => 'ETH', 'callback_data' => 'ETHUSDT'],
                    ['text' => 'BNB', 'callback_data' => 'BNBUSDT']
                ]
            ]
        ];
    }

    public function toResponse($request)
    {
        // TODO: Implement toResponse() method.
    }
}
