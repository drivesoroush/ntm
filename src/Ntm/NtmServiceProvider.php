<?php

namespace Ntcm\Ntm;

use App\Observers\SshCredentialObserver;
use Illuminate\Support\ServiceProvider;
use Ntcm\Ntm\Model\SshCredential;

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
        SshCredential::observe(SshCredentialObserver::class);

        $config = __DIR__ . '/../../config/ntm.php';
        $migrations = __DIR__ . '/../../migrations/';

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
