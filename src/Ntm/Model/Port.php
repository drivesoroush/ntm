<?php

namespace Ntm\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
class Port extends Model {

    protected $fillable = [
        'id',
        'protocol',
        'port_id',
        'state',
        'reason',
        'service',
        'method',
        'conf',
        'host_id',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * @return boolean
     */
    public function isOpen()
    {
        //
    }

    /**
     * @return boolean
     */
    public function isClosed()
    {
        //
    }

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return table_name('ports');
    }

}
