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
            $this->getBackupAddress(),
            $this->getBackupPort(),
            $this->getBackupUsername(),
            $this->getBackupPassword(),
            $this->getDeviceType()
        );

        // run the backup command...
        $executor->execute($command, config('ncm.timeout'));

        // get output...
        $output = $executor->getOutput();

        // save a new backup entity...
        return $this->saveBackup($output);
    }

    /**
     * @return string
     */
    protected function getExecutable()
    {
        return "python3.6 " . remote_config_script_path("backup.py");
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
    protected function getBackupAddress()
    {
        return $this->getHost()->ip;
    }

    /**
     * @return string
     */
    protected function getBackupUsername()
    {
        return $this->getHost()->sshCredentials()->where('is_valid', true)->firstOrFail()->username;
    }

    /**
     * @return string
     */
    protected function getBackupPassword()
    {
        return $this->getHost()->sshCredentials()->where('is_valid', true)->firstOrFail()->password;
    }

    /**
     * @return integer
     */
    protected function getBackupPort()
    {
        return $this->getHost()->sshCredentials()->where('is_valid', true)->firstOrFail()->port;
    }

    /**
     * @return string
     */
    protected abstract function getDeviceType();

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
        $content = file_get_contents(tftp_path($fileName));

        // create new backup...
        return $this->getHost()->backups()->create([
            "configurations" => $content,
        ]);
    }
}