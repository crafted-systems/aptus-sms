<?php

namespace CraftedSystems\Aptus;

use Illuminate\Support\ServiceProvider;

class AptusSMSServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        $this->publishes([
            __DIR__ . '/Config/aptus.php' => config_path('aptus.php'),
        ], 'aptus_config');

        $this->app->singleton(AptusSMS::class, function () {
            return new AptusSMS(config('aptus'));
        });

        $this->app->alias(AptusSMS::class, 'aptus-sms');

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/Config/aptus.php', 'aptus-sms'
        );
    }
}
