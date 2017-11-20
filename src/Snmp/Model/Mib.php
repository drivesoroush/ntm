<?php

namespace Ntcm\Snmp\Model;

use Illuminate\Database\Eloquent\Model;
use Ntcm\Snmp\Scope\MibScope;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
class Mib extends Model {

    use MibScope;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'address',
        'oid',
        'value',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return table_name('mib');
    }

}
