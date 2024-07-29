<?php

namespace App\Models;

use AllowDynamicProperties;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['chat_id', 'message_id', 'updated_id', 'text'];
}
