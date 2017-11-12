<?php

namespace Ntcm\Ntm\Scope;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
trait SshCredentialScope {

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
        $instance = $query->where('address', $attributes['address'])
                          ->where('username', $attributes['username'])
                          ->first();

        if($instance) {
            $query->update($attributes);
        } else {
            // otherwise create...;
            $query->create($attributes);
        }

        // if the host found return it...
        return $instance;
    }
}