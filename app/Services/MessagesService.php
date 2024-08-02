<?php

namespace App\Services;

use App\Models\Message;
use Illuminate\Support\Facades\DB;

class MessagesService
{
    public function createNewMessages(array $messages) {
        foreach ($messages as $message) {
            $newMessage = new Message();
            $newMessage->updated_id = $message['update_id'];
            $newMessage->chat_id = $message['message']['chat']['id'];
            $newMessage->message_id = $message['message']['message_id'];
            $newMessage->text = $this->checkIfSubscription($message['message']['text']);
            $newMessage->save();
        }
    }

    public function getLastUpdateId() {
        $lastMessage = Message::max('updated_id');
        return $lastMessage;
    }

    public function getChatsWithSubscriptions(array $symbols) {
        return DB::table('messages')->whereIn('text', $symbols)->groupBy(['text', 'chat_id'])->get(['chat_id', 'text'])->toArray();
    }

    public function checkIfSubscription(string $text): string {

        $rate_list = [];
        foreach (SymbolService::$SYMBOLS as $symbol) {
            $steps_for_change = levenshtein(strtolower($symbol), strtolower($text));

            if($steps_for_change == 0) {
                return $symbol;
            }

            if($steps_for_change >= strlen($symbol)){
                return $text;
            }

            $similar_characters = similar_text(strtolower($symbol), strtolower($text));

            $rate_list[$steps_for_change - $similar_characters] = $symbol;
        }

        ksort($rate_list);

        return reset($rate_list);
    }
}
