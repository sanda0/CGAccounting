<?php

namespace CodGlo\CGAccounting;

use Illuminate\Support\ServiceProvider;

class CGAccountingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {


        $this->app->singleton('accounting-service', function ($app) {
            return new \CodGlo\CGAccounting\Services\AccountingService();
        });

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        $this->loadMigrationsFrom(__DIR__ . '/migrations');


    }
}
