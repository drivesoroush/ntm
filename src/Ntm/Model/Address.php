<?php

namespace Ntcm\Ntm\Model;

use Illuminate\Database\Eloquent\Model;
use Ntcm\Ntm\Scope\AddressScope;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
class Address extends Model {

    use AddressScope;

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

    /**
     * Mutate the ip address.
     *
     * @param $address
     */
    public function setAddressAttribute($address)
    {
        $this->attributes['address'] = encode_ip($address);
    }

    /**
     * Mutate the ip address.
     *
     * @return string
     */
    public function getAddressAttribute()
    {
        return decode_ip($this->attributes['address']);
    }

}
