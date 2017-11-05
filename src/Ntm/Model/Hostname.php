<?php

namespace Ntcm\Ntm\Model;

use Illuminate\Database\Eloquent\Model;
use Ntcm\Ntm\Scope\HostnameScope;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
class Hostname extends Model {

    use HostnameScope;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'type',
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
        return table_name('host_names');
    }

}
