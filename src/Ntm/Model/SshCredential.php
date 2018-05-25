<?php

namespace Ntcm\Ntm\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Collective\Remote\RemoteFacade as SSH;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Ntcm\Ntm\Scope\SshCredentialScope;
use RuntimeException;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
class SshCredential extends Model {

    use SshCredentialScope;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        //'address',
        'username',
        'password',
        'port',
        'is_valid',
        'host_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_valid' => 'boolean',
        'port'     => 'integer',
    ];

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return table_name('ssh_credentials');
    }

    /**
     * Encrypt the username when you need to store it.
     *
     * @param $username
     */
    public function setUsernameAttribute($username)
    {
        $this->attributes['username'] = encrypt($username);
    }

    /**
     * Encrypt the password when you need to store it.
     *
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = encrypt($password);
    }

    /**
     * Encrypt the username when you need to store it.
     *
     * @return string
     */
    public function getUsernameAttribute()
    {
        return decrypt($this->attributes['username']);
    }

    /**
     * Encrypt the password when you need to store it.
     *
     * @return string
     */
    public function getPasswordAttribute()
    {
        return decrypt($this->attributes['password']);
    }

    /**
     * Get configurations key attribute for this credential.
     *
     * @return string
     */
    public function getConfigKeyAttribute()
    {
        return config_key($this->ip);
    }

    /**
     * Ready the credentials to connect to this host.
     *
     * @return void
     */
    public function auth()
    {
        $connections[$this->configKey] = [
            'host'     => $this->host->ip,
            'username' => $this->username,
            'password' => $this->password,
            'port'     => $this->port,
        ];

        Config::set('remote.connections', $connections);
        Config::set('remote.default', $this->configKey);
    }

    /**
     * Check if credential is valid.
     *
     * @return boolean
     */
    public function checkIsValid()
    {
        // try to run a command...
        try {
            $this->auth();

            $command = "sshpass -p '{$this->password}' ssh -o StrictHostKeyChecking=no -o ConnectTimeout=10  -p {$this->port} {$this->username}@{$this->host->ip} exit; echo $?";

            $output =
                intval(
                    last_line(
                        trim(
                            shell_exec($command)
                        )
                    )
                );

            // SSH::run(['ls']);

            return $output === 0;
        } catch(RuntimeException $e) {
            // remote authentication failure...
            return false;
        } catch(Exception $e) {
            return true;
        }
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
