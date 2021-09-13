<?php

namespace Spirit1086\Restfull\Modules;

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
       if(file_exists(__DIR__.'/Auth/Routes/routes.php'))
       {
         $this->loadRoutesFrom(__DIR__.'/Auth/Routes/routes.php');
       }

       if(is_dir(__DIR__.'/Auth/Migration'))
       {
          $this->loadMigrationsFrom(__DIR__.'/Auth/Migration');
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
