<?php

namespace Ntcm\Ntm\Model;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Ntcm\Enums\HostTypeEnum;
use Ntcm\Ntm\Relation\HostRelation;
use Ntcm\Ntm\Scope\HostScope;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
class Host extends Model {

    use HostScope, HostRelation;

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
        'type',
        'os_generic_id',
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
    public function getMacAttribute()
    {
        return $this->addresses()->whereType('mac')->first();
    }

    /**
     * Get main os model of this host.
     *
     * @return OsDetected
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

            // no os detected...
            if($query->count() === 0) {
                return true;
            }

            // otherwise...
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
    public function getIpAttribute()
    {
        return decode_ip($this->attributes['address']);
    }

    public function backupConfigurations()
    {
        // ip address...
        $address = $this->address;

        // port...
        $port = 22;

        // ssh credentials...
        $credential = $this->sshCredentials()->where('is_valid', true)->firstOrFail();
        $username = $credential->username;
        $password = $credential->password;

        // os...
        $os = $this->osGeneric->alias;
    }
}
