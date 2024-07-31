<?php

namespace App\Services;

use GuzzleHttp\Client;

class TelegramService
{
    private $client;
    private $apiUrl;

    public function __construct()
    {
        $this->apiUrl = "https://api.telegram.org/bot" . config('app.telegram_bot_token') . '/';
        $this->client = new Client();
    }

    public function sendMessage($chatId, $message)
    {
        try {
            $response = $this->client->post($this->apiUrl . 'sendMessage', [
                'json' => [
                    'chat_id' => $chatId,
                    'text' => $message,
                ]
            ]);

            if ($response->getStatusCode() === 200) {
                return json_decode($response->getBody(), true);
            }
        } catch (\Exception $e) {
            // Обробка помилок
            return 'Error: ' . $e->getMessage();
        }

        return null;
    }

    public function sendMessageWithButtons($chatId, $message, $buttons)
    {
        try {
            $response = $this->client->post($this->apiUrl . 'sendMessage', [
                'json' => [
                    'chat_id' => $chatId,
                    'text' => $message,
                    //'reply_markup' => $buttons
                ]
            ]);

            if ($response->getStatusCode() === 200) {
                return json_decode($response->getBody(), true);
            }
        } catch (\Exception $e) {
            // Обробка помилок
            return 'Error: ' . $e->getMessage();
        }

        return null;
    }

    public function getUpdates(int $updated_id)
    {
        try {
            $response = $this->client->get($this->apiUrl . 'getUpdates?offset=' . ($updated_id + 1));

            if ($response->getStatusCode() === 200) {
                return json_decode($response->getBody(), true);
            }
        } catch (\Exception $e) {
            // Обробка помилок
            return 'Error: ' . $e->getMessage();
        }

        return null;
    }
}
