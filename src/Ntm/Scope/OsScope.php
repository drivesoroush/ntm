<?php

namespace Ntcm\Ntm\Scope;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
trait OsScope {

    /**
     * Check whether this hop exists in the database or not.
     *
     * @param        $query
     * @param array  $attributes
     *
     * @return mixed
     */
    public function scopeFindOrCreate($query, $attributes)
    {
        // try to find the host...
        $instance = $query->where('name', $attributes['name'])
                          ->where('address', $attributes['address'])
                          ->first();

        // if the host found return it...
        // otherwise create...
        return $instance ? $instance : $query->create($attributes);
    }

}