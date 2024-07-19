<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $lowStockProducts = \App\Models\Inventory::whereColumn('quantity', '<=', 'reorder_level')->with('product')->get();

            foreach ($lowStockProducts as $item) {
                $user = \App\Models\User::first(); // or fetch the users you want to notify
                $user->notify(new \App\Notifications\LowStockNotification($item->product));
            }
        })->daily();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
