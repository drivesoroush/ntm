<?php

namespace Ntcm\Ntm\Relation;

use Ntcm\Ncm\Model\Backup;
use Ntcm\Ncm\Model\Trap;
use Ntcm\Ntm\Model\Address;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Ntcm\Ntm\Model\Group;
use Ntcm\Ntm\Model\Hop;
use Ntcm\Ntm\Model\Hostname;
use Ntcm\Ntm\Model\OsDetected;
use Ntcm\Ntm\Model\OsGeneric;
use Ntcm\Ntm\Model\Port;
use Ntcm\Ntm\Model\SshCredential;
use Ntcm\Snmp\Model\Mib;
use Ntcm\Snmp\Model\SnmpCredential;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
trait HostRelation {

    /**
     * Get all addresses related to this host.
     *
     * @return HasMany
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Get all hostnames related to this host.
     *
     * @return HasMany
     */
    public function hostnames()
    {
        return $this->hasMany(Hostname::class);
    }

    /**
     * Get all ports related to this host.
     *
     * @return HasMany
     */
    public function ports()
    {
        //return $this->hasMany(Port::class, 'address', 'address');
        return $this->hasMany(Port::class);
    }

    /**
     * Get all mib items related to this host.
     *
     * @return HasMany
     */
    public function mibCollection()
    {
        //return $this->hasMany(Port::class, 'address', 'address');
        return $this->hasMany(Mib::class);
    }

    /**
     * Make os-host relationship.
     *
     * @return HasMany
     */
    public function osCollection()
    {
        //return $this->hasMany(Os::class, 'address', 'address');
        return $this->hasMany(OsDetected::class);
    }

    /**
     * @return BelongsTo
     */
    public function osGeneric()
    {
        return $this->belongsTo(OsGeneric::class);
    }

    /**
     * Create host-credential relationship.
     *
     * @return HasMany
     */
    public function sshCredentials()
    {
        //return $this->hasMany(SshCredential::class, 'address', 'address');
        return $this->hasMany(SshCredential::class);
    }

    /**
     * Create host-credential relationship.
     *
     * @return HasMany
     */
    public function snmpCredentials()
    {
        //return $this->hasMany(SnmpCredential::class, 'address', 'address');
        return $this->hasMany(SnmpCredential::class);
    }

    /**
     * Create host relationship.
     *
     * @return BelongsToMany
     */
    public function groups()
    {
        $pivot = table_name('host_group');

        return $this->belongsToMany(Group::class, $pivot);
    }

    /**
     * Get list of hops.
     *
     * @return HasMany
     */
    public function fromHops()
    {
        return $this->hasMany(Hop::class, 'address_first');
    }

    /**
     * Get list of hops.
     *
     * @return HasMany
     */
    public function toHops()
    {
        return $this->hasMany(Hop::class, 'address_second');
    }

    /**
     * Get host backups.
     *
     * @return HasMany
     */
    public function backups()
    {
        return $this->hasMany(Backup::class);
    }

    /**
     * Get traps for this host.
     *
     * @return HasMany
     */
    public function traps()
    {
        return $this->hasMany(Trap::class, 'address', 'address');
    }
}