<?php

namespace Ntcm\Ntm\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
class Address extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'address',
        'type',
        'vendor',
        'host_id',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return table_name('addresses');
    }

}
