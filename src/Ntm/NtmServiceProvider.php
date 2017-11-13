<?php

namespace Ntcm\Ntm;

use Illuminate\Support\ServiceProvider;
use Ntcm\Ntm\Commands\ScanCommand;
use Ntcm\Ntm\Model\SshCredential;
use Ntcm\Ntm\Observers\SshCredentialObserver;

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
        // register model observers...
        SshCredential::observe(SshCredentialObserver::class);

        // publish configuration files...
        $config = __DIR__ . '/../../config/ntm.php';
        $this->publishes([
            $config => config_path('ntm.php'),
        ], 'config');

        // register migrations...
        $migrations = __DIR__ . '/../../migrations/';
        $this->loadMigrationsFrom($migrations);

        // register console commands...
        $this->commands([
            ScanCommand::class,
        ]);
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
