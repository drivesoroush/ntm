<?php

namespace Ntcm\Ntm\Scope;

use Ntcm\Ntm\Model\Hop;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
trait HopScope {

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
        // try to find the hop...
        $hop = $query
            ->where(function ($query) use ($attributes) {
                $query->where('address_first', $attributes['address_first'])
                      ->where('address_second', $attributes['address_second'])
                      ->where('scan_id', $attributes['scan_id']);
            })
            ->OrWhere(function ($query) use ($attributes) {
                $query->where('address_first', $attributes['address_second'])
                      ->where('address_second', $attributes['address_first'])
                      ->where('scan_id', $attributes['scan_id']);
            })
            ->first();

        // check if rtt isset...
        if( ! isset($attributes['rtt'])) {
            $attributes['rtt'] = 0;
        }

        // update or persist the hop...
        if($hop) {
            $hop->update(['rtt' => $attributes['rtt']]);
        } else {
            $hop = Hop::create($attributes);
        }

        return $hop;
    }

}