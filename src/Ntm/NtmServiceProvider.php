<?php

namespace Ntcm\Ntm;

use Illuminate\Support\ServiceProvider;

class NtmServiceProvider extends ServiceProvider {

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
        $config = __DIR__ . '/../config/gateway.php';
        $migrations = __DIR__ . '/../migrations/';

        $this->publishes([
            $config => config_path('ntm.php'),
        ], 'config');

        $this->loadMigrationsFrom($migrations);

        //$this->publishes([
        //    $migrations => base_path('database/migrations')
        //], 'migrations');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Ntm::class, function () {
            return new Ntm();
        });

        $this->app->alias(Ntm::class, 'ntm');
    }
}
