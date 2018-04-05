<?php

namespace Ntcm\Ncm\Relation;

use Ntcm\Ntm\Model\Host;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
trait TrapRelation {

    /**
     * @return BelongsTo
     */
    public function host()
    {
        return $this->belongsTo(Host::class, 'address', 'address');
    }
}