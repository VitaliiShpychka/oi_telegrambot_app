<?php

namespace App\Providers;

use App\Events\PriceChanged;
use App\Listeners\SendPriceChangeNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    protected $listen = [
        PriceChanged::class => [
            SendPriceChangeNotification::class,
        ],
    ];

    public function boot()
    {
        parent::boot();
    }
}
