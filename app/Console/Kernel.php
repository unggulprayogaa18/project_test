<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Jalankan command 'tugas:cek-kedaluwarsa' setiap hari pada pukul 01:00 pagi.
        $schedule->command('tugas:cek-kedaluwarsa')->everyMinute();
        // OPSI LAIN:
        // $schedule->command('tugas:cek-kedaluwarsa')->everyMinute(); // Untuk testing atau jika deadline sangat kritis
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}