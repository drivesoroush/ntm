<?php

namespace Ntcm\Ncm\Model;

use Illuminate\Database\Eloquent\Model;
use Ntcm\Ncm\Relation\ChangeRelation;
use Ntcm\Ncm\Scope\ChangeScope;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
class Change extends Model {

    use ChangeScope, ChangeRelation;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'from_config',
        'to_config',
        'host_id',
    ];

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return table_name('changes');
    }

}
