<?php

namespace Ntcm\Ntm\Scope;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
trait HostnameScope {

    /**
     * Get reserved ticket types query.
     *
     * @param       $query
     * @param array $attributes
     *
     * @return mixed
     */
    public function scopeFindOrCreate($query, $attributes)
    {
        // try to find the host...
        $instance = $query->where('name', $attributes['name'])
                          ->where('host_id', $attributes['host_id'])
                          ->first();

        // if the host found return it...
        // otherwise create...
        return $instance ? $instance : $query->create($attributes);
    }

}