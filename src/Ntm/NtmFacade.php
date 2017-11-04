<?php

namespace lasselehtinen\MyPackage;

use Illuminate\Support\Facades\Facade;

class NtmFacade extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'ntm';
    }
}