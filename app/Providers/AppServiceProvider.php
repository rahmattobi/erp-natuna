<?php

namespace App\Providers;
use Illuminate\Support\Facades\DB;
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
            // Mengambil data dari database (contoh: notifikasi)
            // $notifications = notification::all();
            $notifications = DB::table('users')
            ->join('notifications', 'users.id', '=', 'notifications.user_id')
            ->select('notifications.*','users.name')
            ->get();

            // Mengirimkan data ke tampilan
            $view->with('notifications', $notifications);
        });
    }
}
