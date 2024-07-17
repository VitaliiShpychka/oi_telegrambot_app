<?php


use App\Http\Controllers\BinanceController;
use Illuminate\Support\Facades\Route;


Route::post('/telegram-bot', [BinanceController::class, 'handle']);
Route::post('/telegram-bot/callback', [BinanceController::class, 'handleCallbackQuery']);
