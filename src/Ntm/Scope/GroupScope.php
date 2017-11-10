<?php

namespace Ntcm\Ntm\Scope;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
trait GroupScope {

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
        // try to find the group...
        $instance = $query->where('name', $attributes['name'])->first();

        // if the group found return it...
        // otherwise create...
        return $instance ? $instance : $query->create($attributes);
    }

}