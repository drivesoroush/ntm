<?php

namespace Ntcm\Snmp\Model;

use Illuminate\Database\Eloquent\Model;
use Nelisys\Snmp;
use Ntcm\Snmp\Scope\SnmpCredentialScope;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
class SnmpCredential extends Model {

    use SnmpCredentialScope;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'address',
        'read',
        'write',
        'is_valid',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_valid' => 'boolean'
    ];

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return table_name('snmp_credentials');
    }

    /**
     * Encrypt the read community when you need to store it.
     *
     * @param $read
     */
    public function setReadAttribute($read)
    {
        $this->attributes['read'] = encrypt($read);
    }

    /**
     * Encrypt the write community when you need to store it.
     *
     * @param $write
     */
    public function setWriteAttribute($write)
    {
        $this->attributes['write'] = encrypt($write);
    }

    /**
     * Encrypt the read community when you need to store it.
     *
     * @return string
     */
    public function getReadAttribute()
    {
        return decrypt($this->attributes['read']);
    }

    /**
     * Encrypt the write community when you need to store it.
     *
     * @return string
     */
    public function getWriteAttribute()
    {
        return decrypt($this->attributes['write']);
    }

    /**
     * Check if credential is valid.
     *
     * @return boolean
     */
    public function checkIsValid()
    {
        // try to run a command...
        $snmp = new Snmp($this->address, $this->read);

        return ! empty($snmp->get('.1.3.6.1.2.1.1.1.0'));
    }

    /**
     * Mutate the address attribute into ip address.
     *
     * @return string
     */
    public function getIpAttribute()
    {
        return decode_ip($this->attributes['address']);
    }
}
