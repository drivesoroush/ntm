<?php

namespace Ntcm\Ntm\Scope;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
trait HostScope {

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
        $instance = $query->where('address', encode_ip($attributes['address']))
                          //->where('scan_id', $attributes['scan_id'])
                          ->first();

        if($instance) {
            // if there is such host then update it...
            $instance->update($attributes);
        } else {
            // otherwise create...
            $instance = $query->create($attributes);
        }

        // return the instance...
        return $instance;
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeScheduled($query)
    {
        return $query->whereNotNull('backup_scheduled');
    }
}