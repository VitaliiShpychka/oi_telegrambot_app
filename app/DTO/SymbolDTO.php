<?php

namespace App\DTO;

class SymbolDTO
{
    private string $name;
    private string $phone;
    private string $symbol;
    private int $price;
    private int $time;

    public function __construct(array $data){
        $this->name = $data["name"];
        $this->phone = $data["phone"];
        $this->symbol = $data["symbol"];
        $this->price = $data["price"];
        $this->time = $data["time"];
    }
    public function getName(): string{
        return $this->name;
    }
    public function getPhone(): string{
        return $this->phone;
    }
    public function getSymbol(): string{
        return $this->symbol;
    }
    public function getPrice(): int{
        return $this->price;
    }
    public function getTime(): int{
        return $this->time;
    }


}
