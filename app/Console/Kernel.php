<?php

namespace App\Console;

use App\Console\Commands\ValidatePriceCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            app(ValidatePriceCommand::class)->checkPrices();
        })->everyTenSeconds();
    }
}

