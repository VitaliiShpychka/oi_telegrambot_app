<?php

namespace App\Http\Controllers;

use App\Http\Responses\TelegramResponse;
use App\Services\BinanceService;
use Illuminate\Http\Request;

class BinanceController extends Controller
{
    protected $binanceRequest;
    protected $telegramResponse;

    public function __construct(BinanceService $binanceRequest, TelegramResponse $telegramResponse)
    {
        $this->binanceRequest = $binanceRequest;
        $this->telegramResponse = $telegramResponse;
    }

    public function handle(Request $request)
    {
        $message = $request->input('message');
        $chatId = $message['chat']['id'];
        $text = $message['text'];

        // Відправка повідомлення з кнопками
        $keyboard = $this->telegramResponse->getInlineKeyboard();
        $this->telegramResponse->sendMessage($chatId, "Виберіть криптовалюту:", $keyboard);
    }

    public function handleCallbackQuery(Request $request): void
    {
        $callbackQuery = $request->input('callback_query');
        $chatId = $callbackQuery['message']['chat']['id'];
        $data = $callbackQuery['data'];

        $prices = $this->binanceRequest->getCoinPrices([$data]);
        $responseText = $this->telegramResponse->formatPrices($prices);

        $this->telegramResponse->sendMessage($chatId, $responseText);
    }
}
