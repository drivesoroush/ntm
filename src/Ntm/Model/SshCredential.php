<?php

namespace Ntcm\Ntm\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
class SshCredential extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'username',
        'password',
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
        return str_replace('.', '-', $this->address);
    }

    /**
     * Ready the credentials to connect to this host.
     *
     * @return void
     */
    public function ready()
    {
        $connections[$this->configKey] = [
            'host'     => $this->address,
            'username' => $this->username,
            'password' => $this->password
        ];

        Config::set('remote.connections', $connections);
        Config::set('remote.default', $this->configKey);
    }
}
