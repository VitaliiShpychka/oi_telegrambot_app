<?php

namespace App\Services;

use App\Models\Message;

class MessagesService
{
    public function createNewMessages(array $messages) {
        foreach ($messages as $message) {
            $newMessage = new Message();
            $newMessage->updated_id = $message['update_id'];
            $newMessage->chat_id = $message['message']['chat']['id'];
            $newMessage->message_id = $message['message']['message_id'];
            $newMessage->text = $message['message']['text'];
            $newMessage->save();
        }
    }

    public function getLastUpdateId() {
        return Message::max('updated_id');
    }

    public function getChatsWithSubscriptions(array $symbols) {
        return Message::whereIn('text', $symbols)->pluck('chat_id')->unique()->toArray();
    }
}
