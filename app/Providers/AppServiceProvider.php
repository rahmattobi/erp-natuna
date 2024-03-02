<?php

namespace App\Providers;
use Carbon\Carbon;
use App\Models\invoice;
use App\Models\notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
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
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $currentDate = Carbon::now();
            $sevenDaysFromNow = $currentDate->copy()->addDays(7);
            $formattedDate = $currentDate->format('Y-m-d');
            $invNotif = Invoice::select('*')
            ->where('nextDate', '<', $sevenDaysFromNow)
            ->where('nextDate', '>=', $formattedDate)
            ->groupBy('id', 'nama_client', 'nama_perusahaan', 'status', 'langganan','tanggal','nextDate','no_inv','created_at','updated_at')
            ->get();

            $notifications = DB::table('users')
            ->join('notifications', 'users.id', '=', 'notifications.user_id')
            ->select('notifications.*','users.name')
            ->get();

            // Mengirimkan data ke tampilan
            $view->with('notifications', $notifications)->with('invNotif', $invNotif);;
        });
    }
}
