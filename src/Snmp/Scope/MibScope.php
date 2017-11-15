<?php

namespace Ntcm\Snmp\Scope;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
trait MibScope {

    /**
     * Check whether this mib item exists in the database or not.
     *
     * @param        $query
     * @param array  $attributes
     *
     * @return mixed
     */
    public function scopeFindOrCreate($query, $attributes)
    {
        // try to find the host...
        $instance = $query->where('address', $attributes['address'])
                          ->where('oid', $attributes['oid'])
                          ->first();

        if($instance) {
            $instance->update($attributes);
        }

        // if the host found return it...
        // otherwise create...
        return $instance;
    }
}