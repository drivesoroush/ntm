<?php

namespace Ntcm\Ntm\Model;

use Collective\Remote\RemoteFacade as SSH;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Ntcm\Ntm\Scope\SshCredentialScope;

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
        'address',
        'username',
        'password',
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
        return config_key($this->address);
    }

    /**
     * Ready the credentials to connect to this host.
     *
     * @return void
     */
    public function auth()
    {
        $connections[$this->configKey] = [
            'host'     => $this->address,
            'username' => $this->username,
            'password' => $this->password
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

            SSH::run(['ls']);

            return true;
        } catch(Exception $e) {
            // remote authentication failure...
            return false;
        }
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
