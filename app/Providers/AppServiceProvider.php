<?php

namespace App\Providers;

use App\Settings;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Settings::class, function() {
            $file = storage_path('app/setting.json');

            if ( !file_exists($file) || trim(file_get_contents($file)) == false ) {
                return Settings::make(storage_path('app/setting.json'), Settings::$default);
            } else {
                return Settings::make(storage_path('app/setting.json'));
            }

        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Key length problem in MySQL < 5.7.7 or MariaDB < 10.2.2
        Schema::defaultStringLength(191);
    }
}
