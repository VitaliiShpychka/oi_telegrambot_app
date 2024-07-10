<?php

namespace App\Http\Responses;

use App\Models\Symbol;
use App\Models\User;
use Illuminate\Contracts\Support\Responsable;

class createMessageResponse implements Responsable
{
    public User $user;
    public Symbol $symbol;
    public function __construct(Symbol $symbol, User $user)
    {
        $this->user = $user;
        $this->symbol = $symbol;
    }
    public function toResponse($request): array
    {
        return[
            'price_start' =>$this->symbol->price_start,
            'price_last'=> $this->user->price_last,
            'time'=>$this->symbol->time
        ];
    }
}
