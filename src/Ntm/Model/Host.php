<?php

namespace Ntcm\Ntm\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Ntcm\Enums\HostTypeEnum;
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
        'type'
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
    public function getMacAttribute()
    {
        return $this->addresses()->whereType('mac')->first();
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
     * @return BelongsTo
     */
    public function scan()
    {
        return $this->belongsTo(Scan::class);
    }

    /**
     * Make os-host relationship.
     *
     * @return HasMany
     */
    public function osCollection()
    {
        return $this->hasMany(Os::class);
    }

    /**
     * Get main os model of this host.
     *
     * @return Os
     */
    public function getOsAttribute()
    {
        return $this->osCollection()->first();
    }

    /**
     * Get host type string attribute.
     *
     * @return string
     */
    public function getTypeStringAttribute()
    {
        if($this->type === HostTypeEnum::NODE_HOST) {
            return "node";
        } else if($this->type === HostTypeEnum::ROUTER_HOST) {
            return "router";
        } else {
            return "switch";
        }
    }

    /**
     * Create host-credential relationship.
     *
     * @return HasMany
     */
    public function sshCredentials()
    {
        return $this->hasMany(SshCredential::class, 'address', 'address');
    }
}
