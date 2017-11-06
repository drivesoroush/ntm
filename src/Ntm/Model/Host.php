<?php

namespace Ntcm\Ntm\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Ntcm\Ntm\Scope\HostScope;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
class Host extends Model {

    use HostScope;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'state',
        'start',
        'end',
        'scan_id',
        'address',
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
        return table_name('hosts');
    }

    /**
     * @return HasMany
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    /**
     * @return HasMany
     */
    public function hostnames()
    {
        return $this->hasMany(Hostname::class);
    }

    /**
     * @return HasMany
     */
    public function ports()
    {
        return $this->hasMany(Port::class);
    }

    /**
     * Make host-scan relationship.
     *
     * @return mixed
     */
    public function scan()
    {
        return $this->belongsTo(Scan::class);
    }

}
