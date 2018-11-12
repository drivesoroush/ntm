<?php

namespace Ntcm\Ntm;

use Exception;
use Carbon\Carbon;
use Ntcm\Exceptions\ProcessExecutionFailedException;
use Ntcm\Ntm\Model\Host;
use Ntcm\Ntm\Util\ProcessExecutor;

trait Restorable {

    /**
     * Restore host configuration.
     *
     * @throws ProcessExecutionFailedException
     */
    public function restore()
    {
        $executor = new ProcessExecutor();

        // store restore content into file and get the stored file name...
        $fileName = $this->storeContentIntoFile();

        // execute the restore script...
        $command = sprintf("%s %s %s %s %s \"%s\" \"%s\" %s",
            $this->getRestoreExecutable(),
            $this->getRestoreAddress(),
            $this->getRestorePort(),
            $this->getRestoreUsername(),
            $this->getRestorePassword(),
            $this->getRestoreSecondPassword(),
            $this->getDeviceType(),
            $fileName
        );

        // run the restore command...
        $executor->execute($command, config('ncm.timeout'));

        // after you ran the script, you can remove the file...
        unlink_if_exists(tftp_path($fileName));
    }

    /**
     * @return string
     */
    protected function getRestoreExecutable()
    {
        return "python" . config("ntm.python.version") . " " . remote_config_script_path("restore.py");
    }

    /**
     * @return Host
     */
    private function getHost()
    {
        return $this->host;
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
     * @return string
     */
    protected function getRestoreSecondPassword()
    {
        return $this->getHost()->sshCredentials()->where('is_valid', true)->firstOrFail()->second_password;
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
     * Store restore content into a file and return filename.
     *
     * @return string
     */
    protected function storeContentIntoFile()
    {
        // get the file name...
        $fileName = $this->getBackupFileName();

        // create the file path...
        $filePath = tftp_path($fileName);

        // write restore contents into the file...
        file_put_contents($filePath, $this->getRestoreContent());

        return $fileName;
    }

    /**
     * Get backup file name.
     *
     * @return string
     */
    public abstract function getBackupFileName();

    /**
     * Determines content of restoration.
     *
     * @return mixed
     */
    protected abstract function getRestoreContent();
}