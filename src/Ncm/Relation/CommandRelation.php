<?php

namespace Ntcm\Ncm\Relation;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Ntcm\Ntm\Model\OsGeneric;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
trait CommandRelation {

    /**
     * Get related vendors (or os generics).
     *
     * @return mixed
     */
    public function vendors()
    {
        $pivot = table_name('command_os_generic');

        return $this->belongsToMany(OsGeneric::class, $pivot);
    }
}