<?php

namespace App\Providers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Laravel\Telescope\TelescopeServiceProvider;
// use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\Facades\Mail;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local') || $this->app->environment('development') || $this->app->environment('production')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }

        if ($this->app->environment('local')) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }


    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Model::preventLazyLoading(!app()->isProduction());

        Str::macro(
            'bytesToHuman',
            function ($value) {
                $units = ['Bytes', 'KB', 'MB', 'GB', 'TB'];

                for ($i = 0; $value > 1024; $i++) {
                    $value /= 1024;
                }

                return number_format($value, 2) . ' ' . $units[$i];
            }
        );

        if (!app()->isProduction()) {
            Mail::alwaysTo('ticket@telekomkollen.se');
        }
    }
}
