<?php

namespace Ntcm\Ntm\Scope;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
trait TargetScope {

    /**
     * Get scheduled scan targets list.
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeScheduled($query)
    {
        return $query->whereNotNull('scheduled');
    }
}