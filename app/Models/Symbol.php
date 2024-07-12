<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

class Symbol extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'symbols';
    protected $with = 'price';
    protected $fillable = [
        'symbol'
    ];

    public function price(): HasOne
    {
        return $this->hasOne(Price::class, "symbol_Id");
    }
}
