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

    /**
     * Get scheduled scans list.
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeScheduled($query)
    {
        return $query->whereNotNull('scheduled')->get();
    }
}