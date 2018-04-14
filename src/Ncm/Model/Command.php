<?php

namespace Ntcm\Ncm\Model;

use Illuminate\Database\Eloquent\Model;
use Ntcm\Exceptions\ProcessExecutionFailedException;
use Ntcm\Ncm\Relation\CommandRelation;
use Ntcm\Ncm\Scope\CommandScope;
use Ntcm\Ntm\Model\Host;
use Ntcm\Ntm\Restorable;
use Carbon\Carbon;
use Ntcm\Ntm\Util\ProcessExecutor;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
class Command extends Model {

    use CommandScope, CommandRelation;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'command',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return table_name('commands');
    }

    /**
     * Execute this command on host.
     *
     * @param string $ip
     *
     * @return string
     * @throws ProcessExecutionFailedException
     */
    public function executeByIp(string $ip)
    {
        return $this->executeByAddress(encode_ip($ip));
    }

    /**
     * Execute this command on host.
     *
     * @param int $address
     *
     * @return string
     * @throws ProcessExecutionFailedException
     */
    public function executeByAddress(int $address)
    {
        $host = Host::where('address', $address)->firstOrFail();

        return $this->execute($host);
    }

    /**
     * Execute this command on host.
     *
     * @param Host $host
     *
     * @return string
     * @throws ProcessExecutionFailedException
     */
    public function execute(Host $host)
    {
        // 192.168.101.7 22 jg @sss123 cisco_ios "show run"
        $credential = $host->sshCredentials()->where('is_valid', true)->firstOrFail();
        $deviceType = $host->osGeneric->alias;

        $executor = new ProcessExecutor();

        // execute the restore script...
        $command = sprintf('%s %s %s %s %s %s "%s"',
            $this->getExecutable(),
            $host->ip,
            $credential->port,
            $credential->username,
            $credential->password,
            $deviceType,
            $this->command
        );

        // run the restore command...
        return $executor->execute($command, config('ncm.timeout'));
    }

    /**
     * @return string
     */
    public function getExecutable()
    {
        return "python3.6 " . remote_config_script_path("show.py");
    }
}
