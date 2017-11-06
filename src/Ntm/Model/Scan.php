<?php

namespace Ntcm\Ntm\Model;

use Illuminate\Database\Eloquent\Model;
use Ntcm\Ntm\Scope\ScanScope;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
class Scan extends Model {

    use ScanScope;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'total_discovered',
        'start',
        'end',
        'state'
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
        return table_name('scans');
    }

    /**
     * Make scan-hop relationship.
     *
     * @return mixed
     */
    public function hops()
    {
        return $this->hasMany(Hop::class);
    }

    /**
     * Make scan-host relationship.
     *
     * @return mixed
     */
    public function hosts()
    {
        return $this->hasMany(Host::class);
    }
}
