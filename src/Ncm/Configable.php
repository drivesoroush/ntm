<?php

namespace Ntcm\Ntm;

use Ntcm\Exceptions\ProcessExecutionFailedException;
use Ntcm\Ntm\Util\ProcessExecutor;

trait Configable {

    /**
     * Run a show command on the asset.
     *
     * @param string $command
     *
     * @return string
     * @throws ProcessExecutionFailedException
     */
    public function show($command)
    {
        $executor = new ProcessExecutor();

        // 192.168.101.7 22 jg @sss123 cisco_ios "show run"
        // run the command...
        $command = sprintf('%s %s %s %s %s %s "%s"',
            $this->getExecutable(),
            $this->getConfigAddress(),
            $this->getConfigPort(),
            $this->getConfigUsername(),
            $this->getConfigPassword(),
            $this->getDeviceType(),
            $command
        );

        // run the backup command...
        $executor->execute($command, config('ncm.timeout'));

        // get output...
        $output = $executor->getOutput();

        return $output;
    }

    /**
     * @return string
     */
    protected function getExecutable()
    {
        return "python3.6 " . remote_config_script_path("show.py");
    }

    /**
     * @return string
     */
    protected function getConfigAddress()
    {
        return $this->getHost()->ip;
    }

    /**
     * @return string
     */
    protected function getConfigUsername()
    {
        return $this->getHost()->sshCredentials()->where('is_valid', true)->firstOrFail()->username;
    }

    /**
     * @return string
     */
    protected function getConfigPassword()
    {
        return $this->getHost()->sshCredentials()->where('is_valid', true)->firstOrFail()->password;
    }

    /**
     * @return integer
     */
    protected function getConfigPort()
    {
        return $this->getHost()->sshCredentials()->where('is_valid', true)->firstOrFail()->port;
    }

    /**
     * @return string
     */
    protected abstract function getDeviceType();

}