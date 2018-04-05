<?php

namespace Ntcm\Ntm;

use Exception;
use Ntcm\Exceptions\ProcessExecutionFailedException;
use Ntcm\Ntm\Model\Host;
use Ntcm\Ntm\Util\ProcessExecutor;

trait Restorable {

    /**
     * Restore host configuration.
     *
     * @param ProcessExecutor $executor
     *
     * @throws ProcessExecutionFailedException
     */
    public function restore(ProcessExecutor $executor)
    {
        $command = sprintf("%s %s %s %s %s %s %s",
            $this->getExecutable(),
            $this->getRestoreAddress(),
            $this->getRestorePort(),
            $this->getRestoreUsername(),
            $this->getRestorePassword(),
            $this->getRestoreOs(),
            $this->storeBackupIntoFile()
        );

        // run the restore command...
        $executor->execute($command, $this->getTimeout());
    }

    /**
     * @return string
     */
    protected function getExecutable()
    {
        return remote_config_script_path("restore.py");
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
        return $this->getHost()->username;
    }

    /**
     * @return string
     */
    protected function getRestorePassword()
    {
        return $this->getHost()->password;
    }

    /**
     * @return integer
     */
    protected function getRestorePort()
    {
        return $this->getHost()->port;
    }

    /**
     * @return string
     */
    protected function getRestoreOs()
    {
        return $this->getHost()->osGeneric->alias;
    }

    /**
     * TODO...
     *
     * @return string
     */
    protected function storeBackupIntoFile()
    {
        $this->getRestoreContent();

        return "";
    }

    /**
     * Determines content of restoration.
     *
     * @return mixed
     */
    protected abstract function getRestoreContent();
}