<?php

namespace Ntcm\Ncm\Model;

use Illuminate\Database\Eloquent\Model;
use Ntcm\Ncm\Relation\BackupRelation;
use Ntcm\Ncm\Relation\TrapRelation;
use Ntcm\Ncm\Scope\BackupScope;
use Ntcm\Ncm\Scope\TrapScope;
use Ntcm\Ntm\Restorable;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
class Trap extends Model {

    use TrapScope, TrapRelation;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //'id',
        'address',
        'body',
        'created_at',
    ];

    /**
     * Disable updated at attribute.
     *
     * @param string $date
     */
    public function setUpdatedAtAttribute($date)
    {
        // ...
    }

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return table_name('traps');
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
     * Mutate the address attribute into ip address.
     *
     * @return string
     */
    public function getAddressAttribute()
    {
        return decode_ip($this->attributes['address']);
    }

}
