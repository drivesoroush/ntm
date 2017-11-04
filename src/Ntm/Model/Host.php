<?php

namespace Ntcm\Ntm\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
class Host extends Model {

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
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'start',
        'end',
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
     * Get address for this host.
     *
     * @return string
     */
    public function getAddressAttribute()
    {
        return $this->addresses()->firstOrFail()->address;
    }
}
