<?php

namespace Ntcm\Ntm;

use Exception;
use Ntcm\Exceptions\ProcessExecutionFailedException;
use Ntcm\Ncm\Model\Backup;
use Ntcm\Ntm\Model\Host;
use Ntcm\Ntm\Util\ProcessExecutor;

trait Backupable {

    /**
     * Restore host configuration.
     *
     * @throws ProcessExecutionFailedException
     */
    public function backup()
    {
        $executor = new ProcessExecutor();

        // run the command...
        $command = sprintf("%s %s %s %s %s %s",
            $this->getExecutable(),
            $this->getRestoreAddress(),
            $this->getRestorePort(),
            $this->getRestoreUsername(),
            $this->getRestorePassword(),
            $this->getDeviceType()
        );

        // run the backup command...
        $output = $executor->execute($command, config('ncm.timeout'));

        // save a new backup entity...
        return $this->saveBackup($output);
    }

    /**
     * @return string
     */
    protected function getExecutable()
    {
        return remote_config_script_path("backup.py");
    }

    /**
     * @return Host
     */
    private function getHost()
    {
        return $this;
    }

    /**
     * @return string
     */
    protected function getRestoreAddress()
    {
        return $this->getHost()->ip;
    }

    /**
     * @return string
     */
    protected function getRestoreUsername()
    {
        return $this->getHost()->sshCredentials()->where('is_valid', true)->firstOrFail()->username;
    }

    /**
     * @return string
     */
    protected function getRestorePassword()
    {
        return $this->getHost()->sshCredentials()->where('is_valid', true)->firstOrFail()->password;
    }

    /**
     * @return integer
     */
    protected function getRestorePort()
    {
        return $this->getHost()->sshCredentials()->where('is_valid', true)->firstOrFail()->port;
    }

    /**
     * @return string
     */
    protected function getDeviceType()
    {
        return $this->getHost()->osGeneric->alias;
    }

    /**
     * Create a new backup entity for the host.
     *
     * @param string $fileName
     *
     * @return Backup
     */
    protected function saveBackup($fileName)
    {
        // fetch the content...
        $content = file_get_contents($fileName);

        // create new backup...
        return $this->getHost()->backups()->create([
            "configurations" => $content,
        ]);
    }
}