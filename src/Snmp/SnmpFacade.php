<?php

namespace lasselehtinen\MyPackage;

use Illuminate\Support\Facades\Facade;

class SnmpFacade extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'snmp';
    }
}