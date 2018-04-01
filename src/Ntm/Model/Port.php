<?php

namespace Ntcm\Ntm\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Ntcm\Ntm\Scope\PortScope;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
class Port extends Model {

    use PortScope;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        //'address',
        'protocol',
        'port_id',
        'state',
        'reason',
        'service',
        'method',
        'conf',
        'host_id',
        // service attributes...
        'product',
        'version',
        'extra_info',
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
        return true;
    }

    /**
     * @return boolean
     */
    public function isClosed()
    {
        return false;
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

    /**
     * Create relation to host model.
     *
     * @return BelongsTo
     */
    public function host()
    {
        return $this->belongsTo(Host::class);
    }

    ///**
    // * Mutate the ip address.
    // *
    // * @param $address
    // */
    //public function setAddressAttribute($address)
    //{
    //    $this->attributes['address'] = encode_ip($address);
    //}
    //
    ///**
    // * Mutate the address attribute into ip address.
    // *
    // * @return string
    // */
    //public function getIpAttribute()
    //{
    //    return decode_ip($this->attributes['address']);
    //}

}
