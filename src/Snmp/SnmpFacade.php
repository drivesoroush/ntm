<?php

namespace Ntcm\Snmp;

use Illuminate\Support\Facades\Facade;

class SnmpFacade extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'snmp';
    }
}