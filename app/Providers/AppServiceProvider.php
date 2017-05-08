<?php

namespace App\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        Log::info('Service Provider boot');
//        $user = Session::get('user', '');
//        $username = 'unknown';
//        if ($user != ''){
//            $username = $user->username;
//        }
//        view()->share([
//            'username' => $username
//        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
