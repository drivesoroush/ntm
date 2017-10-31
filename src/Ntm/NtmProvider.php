<?php

namespace Ntm;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class NtmProvider extends ServiceProvider {

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

        $this->publishes([
            $migrations => base_path('database/migrations')
        ], 'migrations');
    }

}
