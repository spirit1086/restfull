<?php

namespace App\Modules;

use Illuminate\Support\ServiceProvider;

class ModulesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
                    if(file_exists(__DIR__.'/Pass/Routes/routes.php'))
                    {
                        $this->loadRoutesFrom(__DIR__.'/Pass/Routes/routes.php');
                    }

                    if(is_dir(__DIR__.'/Pass/Migration'))
                    {
                        $this->loadMigrationsFrom(__DIR__.'/Pass/Migration');
                    }

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
