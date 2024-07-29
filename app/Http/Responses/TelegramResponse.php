<?php

namespace App\Http\Responses;

use GuzzleHttp\Client;

class TelegramResponse
{
    protected $client;
    protected $telegramApiUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->telegramApiUrl = 'https://api.telegram.org/bot' . env('TELEGRAM_BOT_TOKEN') . '/';
    }

    public function sendMessage($chatId, $text, $keyboard = null)
    {
        $params = [
            'chat_id' => $chatId,
            'text' => $text
        ];

        if ($keyboard) {
            $params['reply_markup'] = json_encode($keyboard);
        }

        $this->client->post($this->telegramApiUrl . 'sendMessage', [
            'json' => $params
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
                    ['text' => 'BNB', 'callback_data' => 'BNBUSDT'],
                    ['text' => 'LTC', 'callback_data' => 'LTCUSDT']
                ]
            ]
        ];
    }

    public function toResponse($request)
    {
        // TODO: Implement toResponse() method.
    }
}
