<?php

namespace Vendor\CGAccounting;

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

			// Merges the configuration file 'config/config.php' into the 'xaccounting' configuration namespace.
			// $this->mergeConfigFrom(__DIR__.'/config/config.php', 'xaccounting');

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
			// Loads routes defined in 'routes.php' file.
			// $this->loadRoutesFrom(__DIR__.'/routes.php');

			// Automatically loads migrations from the 'migrations' directory.
			$this->loadMigrationsFrom(__DIR__.'/migrations');


    }
}
