<?php

namespace Ntcm\Ntm;

use Illuminate\Support\Facades\Facade;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
class NtmFacade extends Facade {

    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'ntm';
    }
}