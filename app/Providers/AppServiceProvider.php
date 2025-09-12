<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

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
        // تأكد من ضبط اللغة عند الإقلاع
        /*
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }
        */

        // إجبار استخدام HTTPS في بيئة production
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
    }
}
