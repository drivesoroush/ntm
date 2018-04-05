<?php

namespace Ntcm\Ncm;

use Illuminate\Support\ServiceProvider;
use Ntcm\Ntm\Commands\TrapHandlerCommand;

class NcmServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var boolean
     */
    protected $defer = false;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // publish configuration files...
        $config = __DIR__ . '/../../config/ncm.php';
        $this->publishes([
            $config => config_path('ncm.php'),
        ], 'config');

        // register migrations...
        $migrations = __DIR__ . '/migrations/';
        $this->loadMigrationsFrom($migrations);

        // register console commands...
        $this->commands([
            TrapHandlerCommand::class
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // ...
    }
}
