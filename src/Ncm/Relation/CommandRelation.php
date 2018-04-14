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
        return $this->belongsToMany(OsGeneric::class, 'commands_os_generic');
    }
}