<?php

namespace Ntcm\NtmTest;

use Ntcm\Ntm\Ntm;
use Ntcm\Ntm\NtmServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase {

    /**
     * Load package service provider
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [NtmServiceProvider::class];
    }

    /**
     * Load package alias
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'Ntm' => Ntm::class,
        ];
    }
}