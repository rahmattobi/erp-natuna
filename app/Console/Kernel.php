<?php

namespace App\Console;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->call(function () {
        //     // Query untuk mengambil invoice dengan duedate kurang dari 7 hari dari sekarang
        //     $invoices = DB::table('invoices')
        //         ->whereDate('nextDate', '<=', Carbon::now()->addDays(7)->toDateString())
        //         ->get();

        //     foreach ($invoices as $invoice) {
        //         // Kirim notifikasi ke pemilik invoice
        //         $user = Auth::user();
        //         if ($user && $user->id <= 2) {
        //             $user->notify(new DueDateNotification($invoice));
        //         }
        //     }
        // })->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
