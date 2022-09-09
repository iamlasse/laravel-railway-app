<?php

namespace App\Providers;

use App\Faker\FrameworkProvider;
// use App\Faker\TelekomFaker;
use Faker\Factory;
use Illuminate\Support\ServiceProvider;

class TelekomFakerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            Generator::class,
            function () {
                $faker = Factory::create();
                $faker->addProvider(new FrameworkProvider($faker));
                dd($faker);
                return $faker;
            }
        );
    }
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
