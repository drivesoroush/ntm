<?php

namespace Ntcm\Snmp;

use Illuminate\Support\Facades\Facade;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
class SnmpFacade extends Facade {

    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'snmp';
    }
}