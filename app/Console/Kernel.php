<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected $commands = [
            \App\Console\Commands\SendCompetitionReminders::class,
        ];
    
        protected function schedule(Schedule $schedule)
    {
        // Tambahkan di sini semua schedule kamu
        $schedule->command('reminders:send')->everyMinute();

        
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands'); // <--- ini penting
        require base_path('routes/console.php');
    }
}
