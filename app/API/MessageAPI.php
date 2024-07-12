<?php

namespace App\API;

class MessageAPI
{
    public static function sendMessage(string $phone, string $message): void
    {
        file_put_contents(storage_path("logs/message.log"), " Price: " . $phone. " Message ". $message. PHP_EOL, FILE_APPEND);
    }

}
