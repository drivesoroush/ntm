<?php

namespace Ntcm\Ntm\Model;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Config;
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

    /**
     * Create host relationship.
     *
     * @return BelongsToMany
     */
    public function groups()
    {
        $pivot = config('ntm.tables.host_group', 'mapper_host_group');

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
     * Get configurations key attribute for this credential.
     *
     * @return string
     */
    public function getConfigKeyAttribute()
    {
        return config_key($this->address);
    }

    /**
     * Ready the remote package to connect to this host.
     *
     * @param string $username
     * @param string $password
     *
     * @return void
     */
    public function auth($username, $password)
    {
        $connections[$this->configKey] = [
            'host'     => $this->address,
            'username' => $username,
            'password' => $password
        ];

        Config::set('remote.connections', $connections);
        Config::set('remote.default', $this->configKey);
    }

    /**
     * Check if the host is remotable.
     *
     * @return boolean
     */
    public function getIsRemotableAttribute()
    {
        try {
            $query = $this->osCollection();

            $query->where(function ($query) {
                foreach(config('ntm.remotable') as $remotable) {
                    $query->orWhere('os_family', $remotable);
                }
            });

            return $query->count() > 0;
        } catch(Exception $e) {
            return false;
        }
    }
}
