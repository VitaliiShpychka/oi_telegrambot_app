<?php


use App\Http\Controllers\BinanceController;
use App\Http\Controllers\PriceController;
use Illuminate\Support\Facades\Route;


Route::post('/telegram-bot', [BinanceController::class, 'handle']);
Route::post('/telegram-bot/callback', [BinanceController::class, 'handleCallbackQuery']);

Route::get('/check-prices', [PriceController::class, 'checkPrices']);
