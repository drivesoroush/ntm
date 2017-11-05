<?php

namespace Ntcm\Ntm\Scope;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
trait ScanScope {

    /**
     * Get reserved ticket types query.
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeLast($query)
    {
        return $query->orderBy('id', 'desc')->first();
    }

}